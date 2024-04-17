<?php

return [
    'product' => env('STRIPE_PRODUCT'),
    'pricing' => [
        'monthly' => env('STRIPE_PRICING_MONTHLY'),
        'yearly' => env('STRIPE_PRICING_YEARLY'),
        'lifetime' => env('STRIPE_PRICING_LIFETIME')
    ]
];