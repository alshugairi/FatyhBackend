<?php

return [
    'test_mode' => env('KASHIER_TEST_MODE', true),
    'merchant_id' => env('KASHIER_MERCHANT_ID'),
    'api_key' => env('KASHIER_API_KEY'),
    'currency' => env('KASHIER_CURRENCY', 'EGP'),
    'debug' => env('KASHIER_DEBUG', false)
];
