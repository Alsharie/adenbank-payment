<?php

return [
    'auth' => [
        'username' => env('ADENBANK_MERCHANT_USERNAME'),
        'password' => env('ADENBANK_MERCHANT_PASSWORD'),
    ],
    'url' => [
        'base' => env('ADENBANK_BASE_URL', 'https://api.adenbank.ye:49901'),
    ]
];
