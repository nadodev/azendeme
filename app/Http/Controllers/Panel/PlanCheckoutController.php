<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PlanCheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:premium,master',
        ]);

        $user = Auth::user();
        $priceIdOrProductId = Config::get('stripe.prices.' . $request->plan);

        if (!$priceIdOrProductId) {
            return back()->withErrors(['plan' => 'Plano indisponível para cobrança.']);
        }

        \Stripe\Stripe::setApiKey(Config::get('stripe.secret'));

        try {
            // Accept either a Price ID (price_...) or a Product ID (prod_...)
            $resolvedPriceId = null;
            $resolvedPrice = null;
            if (str_starts_with($priceIdOrProductId, 'price_')) {
                // Validate price exists and is recurring
                $price = \Stripe\Price::retrieve($priceIdOrProductId);
                if (!isset($price->recurring)) {
                    return back()->withErrors(['plan' => 'O Price informado não é recorrente. Crie um Price recorrente (mensal) no Stripe.']);
                }
                $resolvedPrice = $price;
                $resolvedPriceId = $price->id;
            } elseif (str_starts_with($priceIdOrProductId, 'prod_')) {
                $product = \Stripe\Product::retrieve($priceIdOrProductId);
                // Find an active recurring price for this product
                $prices = \Stripe\Price::all(['product' => $product->id, 'active' => true, 'limit' => 20]);
                foreach ($prices->data as $p) {
                    if (isset($p->recurring)) { $resolvedPrice = $p; $resolvedPriceId = $p->id; break; }
                }
                if (!$resolvedPriceId) {
                    return back()->withErrors(['plan' => 'Nenhum Price recorrente ativo encontrado para este produto no Stripe.']);
                }
            } else {
                return back()->withErrors(['plan' => 'Identificador Stripe inválido. Use um Price (price_...) ou Product (prod_...).']);
            }

            if (!$resolvedPriceId) {
                return back()->withErrors(['plan' => 'Não foi possível resolver o preço do plano no Stripe.']);
            }

            $session = \Stripe\Checkout\Session::create([
                'mode' => 'subscription',
                'payment_method_types' => ['card'],
                'customer_email' => $user->email,
                'line_items' => [[
                    'price' => $resolvedPriceId,
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'user_id' => (string) $user->id,
                    'target_plan' => $request->plan,
                ],
                'success_url' => url('/panel/planos?success=1'),
                'cancel_url' => url('/panel/planos?canceled=1'),
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            \Log::error('Stripe Checkout error', ['message' => $e->getMessage()]);
            return back()->withErrors(['plan' => 'Erro ao iniciar pagamento: ' . $e->getMessage()]);
        }

        return redirect($session->url);
    }

    public function billingPortal(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->stripe_customer_id) {
            return back()->withErrors(['billing' => 'Nenhuma assinatura ativa encontrada.']);
        }

        \Stripe\Stripe::setApiKey(Config::get('stripe.secret'));

        try {
            // Check if we're in test mode or live mode
            $isTestMode = str_starts_with(Config::get('stripe.secret'), 'sk_test_');
            
            $session = \Stripe\BillingPortal\Session::create([
                'customer' => $user->stripe_customer_id,
                'return_url' => url('/panel/perfil'),
            ], [
                'stripe_account' => null, // Use default account
            ]);

            return redirect($session->url);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            if (str_contains($e->getMessage(), 'No configuration provided')) {
                $mode = str_starts_with(Config::get('stripe.secret'), 'sk_test_') ? 'Test' : 'Live';
                return back()->withErrors(['billing' => "Portal de cobrança não configurado no modo {$mode}. Configure em: https://dashboard.stripe.com/settings/billing/portal"]);
            }
            return back()->withErrors(['billing' => 'Erro ao acessar portal de cobrança: ' . $e->getMessage()]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return back()->withErrors(['billing' => 'Erro ao acessar portal de cobrança: ' . $e->getMessage()]);
        }
    }
}


