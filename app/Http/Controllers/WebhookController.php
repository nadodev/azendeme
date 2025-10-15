<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleStripe(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = Config::get('stripe.webhook_secret');
        \Stripe\Stripe::setApiKey(Config::get('stripe.secret'));

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\Throwable $e) {
            Log::warning('Stripe webhook signature verification failed', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        }

        Log::info('Stripe webhook received', [
            'type' => $event->type,
            'event_id' => $event->id ?? null,
            'created' => $event->created ?? null,
        ]);

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object; // \Stripe\Checkout\Session
            $userId = (int) ($session->metadata->user_id ?? 0);
            $targetPlan = (string) ($session->metadata->target_plan ?? '');
            $customerId = is_string($session->customer ?? null) ? $session->customer : null;
            $subscriptionId = is_string($session->subscription ?? null) ? $session->subscription : null;

            Log::info('Checkout session metadata', [
                'user_id' => $userId,
                'target_plan' => $targetPlan,
                'customer_id' => $customerId,
                'subscription_id' => $subscriptionId,
            ]);
            
            // If target_plan not provided, derive from line_items price
            if (!$targetPlan) {
                try {
                    $expanded = \Stripe\Checkout\Session::retrieve([
                        'id' => $session->id,
                        'expand' => ['line_items.data.price', 'subscription']
                    ]);
                    $priceId = (string)($expanded->line_items->data[0]->price->id ?? '');
                    $prices = Config::get('stripe.prices', []);
                    foreach ($prices as $planKey => $configured) {
                        if ($configured && is_string($configured) && str_starts_with($configured, 'price_') && $configured === $priceId) {
                            $targetPlan = $planKey;
                            break;
                        }
                    }
                    // Capture subscription if missing
                    if (!$subscriptionId && isset($expanded->subscription)) {
                        $subscriptionId = is_string($expanded->subscription) ? $expanded->subscription : ($expanded->subscription->id ?? null);
                    }
                } catch (\Throwable $e) {
                    Log::warning('Failed to derive plan from checkout session', ['error' => $e->getMessage()]);
                }
            }

            if ($userId && in_array($targetPlan, ['premium', 'master'], true)) {
                $user = User::find($userId);
                if ($user) {
                    $user->plan = $targetPlan;
                    if ($customerId) { $user->stripe_customer_id = $customerId; }
                    if ($subscriptionId) { $user->stripe_subscription_id = $subscriptionId; }
                    $user->save();
                    Log::info('User plan upgraded via checkout.session.completed', [
                        'user_id' => $user->id,
                        'plan' => $user->plan,
                        'stripe_customer_id' => $user->stripe_customer_id,
                        'stripe_subscription_id' => $user->stripe_subscription_id,
                        'metadata' => $session->metadata->toArray(),
                    ]);
                }
            }
        }

        if ($event->type === 'customer.subscription.created') {
            $subscription = $event->data->object; // \Stripe\Subscription
            $customerId = (string) ($subscription->customer ?? '');
            $item = $subscription->items->data[0] ?? null;
            $priceId = (string) ($item->price->id ?? '');
            $productId = (string) ($item->price->product ?? '');
            if ($customerId && ($priceId || $productId)) {
                // Match user by stripe_customer_id or fallback by email from Stripe Customer
                $user = User::where('stripe_customer_id', $customerId)->first();
                if (!$user) {
                    try {
                        $customer = \Stripe\Customer::retrieve($customerId);
                        $email = is_string($customer->email ?? null) ? $customer->email : null;
                        if ($email) {
                            $user = User::where('email', $email)->first();
                        }
                    } catch (\Throwable $e) {
                        Log::warning('subscription.created: unable to retrieve customer', ['error' => $e->getMessage()]);
                    }
                }
                if ($user) {
                    $user->stripe_customer_id = $customerId;
                    $user->stripe_subscription_id = (string) ($subscription->id ?? '');
                    // Map configured plan by price or product
                    $prices = Config::get('stripe.prices', []);
                    $targetPlan = null;
                    foreach ($prices as $planKey => $configured) {
                        if (!$configured || !is_string($configured)) { continue; }
                        if (str_starts_with($configured, 'price_') && $configured === $priceId) { $targetPlan = $planKey; break; }
                        if (str_starts_with($configured, 'prod_') && $configured === $productId) { $targetPlan = $planKey; break; }
                    }
                    if ($targetPlan && in_array($targetPlan, ['premium', 'master'], true)) {
                        $user->plan = $targetPlan;
                    }
                    $user->save();
                    Log::info('User subscription created update', [
                        'user_id' => $user->id,
                        'plan' => $user->plan,
                        'stripe_customer_id' => $user->stripe_customer_id,
                        'stripe_subscription_id' => $user->stripe_subscription_id,
                        'price_id' => $priceId,
                        'product_id' => $productId,
                    ]);
                } else {
                    Log::warning('subscription.created: no user matched', [
                        'customer_id' => $customerId,
                        'price_id' => $priceId,
                        'product_id' => $productId,
                    ]);
                }
            }
        }

        if ($event->type === 'customer.subscription.deleted') {
            $subscription = $event->data->object; // \Stripe\Subscription
            $subscriptionId = (string) ($subscription->id ?? '');
            if ($subscriptionId) {
                $user = User::where('stripe_subscription_id', $subscriptionId)->first();
                if ($user) {
                    $user->plan = 'free';
                    $user->save();
                    Log::info('User plan downgraded via subscription.deleted', [
                        'user_id' => $user->id,
                        'plan' => $user->plan,
                    ]);
                }
            }
        }

        if ($event->type === 'invoice_payment.paid') {
            // Fallback: map subscription price to plan on successful invoice payment
            try {
                $invoice = $event->data->object; // \Stripe\Invoice
                $subscriptionId = (string)($invoice->subscription ?? '');
                if ($subscriptionId) {
                    $subscription = \Stripe\Subscription::retrieve(['id' => $subscriptionId, 'expand' => ['items.data.price']]);
                    $priceId = (string)($subscription->items->data[0]->price->id ?? '');
                    $prices = Config::get('stripe.prices', []);
                    $targetPlan = null;
                    foreach ($prices as $planKey => $configured) {
                        if ($configured && is_string($configured) && str_starts_with($configured, 'price_') && $configured === $priceId) {
                            $targetPlan = $planKey;
                            break;
                        }
                    }
                    if ($targetPlan) {
                        $user = User::where('stripe_subscription_id', $subscriptionId)->first();
                        if (!$user && is_string($subscription->customer ?? null)) {
                            $user = User::where('stripe_customer_id', (string)$subscription->customer)->first();
                        }
                        if ($user) {
                            $user->plan = $targetPlan;
                            $user->save();
                            Log::info('User plan updated via invoice_payment.paid', [
                                'user_id' => $user->id,
                                'plan' => $user->plan,
                            ]);
                        }
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('invoice_payment.paid handling failed', ['error' => $e->getMessage()]);
            }
        }

        return response('ok', 200);
    }
}


