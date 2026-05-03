<?php

return [
    'store_id' => env('SSLCOMMERZ_STORE_ID', 'testbox'),
    'store_password' => env('SSLCOMMERZ_STORE_PASSWORD', 'qwerty'),
    'sandbox' => env('SSLCOMMERZ_SANDBOX', true),
    'currency' => env('SSLCOMMERZ_CURRENCY', 'BDT'),
    'frontend_success_url' => env('PAYMENT_SUCCESS_URL'),
    'frontend_fail_url' => env('PAYMENT_FAIL_URL'),
    'frontend_cancel_url' => env('PAYMENT_CANCEL_URL'),
];
