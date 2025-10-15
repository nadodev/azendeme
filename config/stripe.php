<?php

return [
    'secret' => env('STRIPE_SECRET', ''),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),

    // Map plan slugs to Stripe Price IDs
    'prices' => [
        'free' => null,
        'premium' => env('STRIPE_PRICE_PREMIUM', ''),
        'master' => env('STRIPE_PRICE_MASTER', ''),
    ],
];


