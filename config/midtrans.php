<?php

return [
    'mode' => env('MIDTRANS_MODE', 'production'),

    'sandbox' => [
        'api_url' => 'https://api.sandbox.midtrans.com/',
        'snap_url' => 'https://app.sandbox.midtrans.com/snap/',
        'server_key' => env('MIDTRANS_SANDBOX_SERVER_KEY'),
        'client_key' => env('MIDTRANS_SANDBOX_CLIENT_KEY'),
    ],

    'production' => [
        'api_url' => 'https://app.midtrans.com/',
        'snap_url' => 'https://app.midtrans.com/snap/',
        'server_key' => env('MIDTRANS_PRODUCTION_SERVER_KEY'),
        'client_key' => env('MIDTRANS_PRODUCTION_CLIENT_KEY'),
    ],

    'payment_method' => [
        'card' => [
            'table' => 'registered_cards',
        ],
    ],

    'subscription' => [
        'has_retry_schedule' => true,

        'retry_schedule' => [
            'interval' => 1,

            'interval_unit' => 'day',

            'max_interval' => 3,
        ],
    ],
];
