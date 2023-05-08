<?php

return [

    /*
    |--------------------------------------------------------------------------
    | M-Pesa API Credentials
    |--------------------------------------------------------------------------
    |
    | These are the credentials needed to access the M-Pesa API. You can obtain
    | these credentials from the Safaricom Developer Portal.
    |
    */

    'credentials' => [
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
        'passkey' => env('MPESA_PASSKEY'),
        'shortcode' => env('MPESA_SHORTCODE'),
    ],

    /*
    |--------------------------------------------------------------------------
    | M-Pesa API Endpoints
    |--------------------------------------------------------------------------
    |
    | These are the endpoints for the various M-Pesa API services. You can
    | customize these endpoints if necessary.
    |
    */

    'live' => [
        'auth' => 'https://api.safaricom.co.ke/oauth/v1/generate',
        'b2c' => 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest',
        'b2b' => 'https://api.safaricom.co.ke/mpesa/b2b/v1/paymentrequest',
        'c2b' => [
            'register_url' => 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl',
            'simulate' => 'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate',
        ],
        'stk' => [
            'push' => 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            'query' => 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query',
        ],
        'reversal' => 'https://api.safaricom.co.ke/mpesa/reversal/v1/request',
        'transaction_status' => 'https://api.safaricom.co.ke/mpesa/transactionstatus/v1/query',
        'account_balance' => 'https://api.safaricom.co.ke/mpesa/accountbalance/v1/query',
    ],


    /*
    |------------------------------------------------------------------------------
    |
    |
    |Sandbox endpoints
    |
    */
    'sandbox' => [
        'auth' => 'https://sandbox.safaricom.co.ke/oauth/v1/generate',
        'b2c' => 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest',
        'b2b' => 'https://sandbox.safaricom.co.ke/mpesa/b2b/v1/paymentrequest',
        'c2b' => [
            'register_url' => 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl',
            'simulate' => 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate',
        ],
        'stk' => [
            'push' => 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            'query' => 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query',
        ],
        'reversal' => 'https://sandbox.safaricom.co.ke/mpesa/reversal/v1/request',
        'transaction_status' => 'https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query',
        'account_balance' => 'https://sandbox.safaricom.co.ke/mpesa/accountbalance/v1/query',
    ],

    /*
    |--------------------------------------------------------------------------
    | M-Pesa Callback URLs
    |--------------------------------------------------------------------------
    |
    | These are the URLs where the M-Pesa API will send the transaction callbacks.
    | You can customize these URLs if necessary.
    |
    */

    'callback_urls' => [
        'validation' => env('MPESA_VALIDATION_URL'),
        'confirmation' => env('MPESA_CONFIRMATION_URL'),
        'c2b' => env('MPESA_C2B_URL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | M-Pesa Timeout
    |--------------------------------------------------------------------------
    |
    | This value determines the maximum time (in seconds) to wait for a response
    | from the M-Pesa API before timing out.
    |
    */

    'timeout' => env('MPESA_TIMEOUT', 60),

];
