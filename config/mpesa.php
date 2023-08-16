<?php
return [
    /*
|--------------------------------------------------------------------------
| Default Account
|--------------------------------------------------------------------------
|
| This is the default account to be used when none is specified.
*/

    'default' => 'staging',

    /*
|--------------------------------------------------------------------------
| File Cache Location
|--------------------------------------------------------------------------
|
| When using the Native Cache driver, this will be the relative directory
| where the cache information will be stored.
*/

    'cache_location' => '../cache',

    /*
|--------------------------------------------------------------------------
| Accounts
|--------------------------------------------------------------------------
|
| These are the accounts that can be used with the package. You can configure
| as many as needed. Two have been setup for you.
|
| Sandbox: Determines whether to use the sandbox, Possible values: sandbox | production
| Initiator: This is the username used to authenticate the transaction request
| LNMO:
|    shortcode: The till number
|    passkey: The passkey for the till number
|    callback: Endpoint that will be be queried on completion or failure of the transaction.
|
*/

    'accounts' => [
        'staging' => [
            'sandbox' => true,
            'key' => 'your development consumer key',
            'secret' => 'your development consumer secret',
            'initiator' => 'your development username',
            'id_validation_callback' => 'http://example.com/callback?secret=some_secret_hash_key',
            'lnmo' => [
                'paybill' => 'your development paybill number',
                'shortcode' => 'your development business code',
                'passkey' => 'your development passkey',
                'callback' => 'http://example.com/callback?secret=some_secret_hash_key',
            ]
        ],

        'paybill_1' => [
            'sandbox' => false,
            'key' => 'your production consumer key',
            'secret' => 'your production consumer secret',
            'initiator' => 'your production username',
            'id_validation_callback' => 'http://example.com/callback?secret=some_secret_hash_key',
            'lnmo' => [
                'paybill' => 'your production paybill number',
                'shortcode' => 'your production business code',
                'passkey' => 'your production passkey',
                'callback' => 'http://example.com/callback?secret=some_secret_hash_key',
            ]
        ],

        'paybill_2' => [
            'sandbox' => false,
            'key' => 'your production consumer key',
            'secret' => 'your production consumer secret',
            'initiator' => 'your production username',
            'id_validation_callback' => 'http://example.com/callback?secret=some_secret_hash_key',
            'lnmo' => [
                'paybill' => 'your production paybill number',
                'shortcode' => 'your production business code',
                'passkey' => 'your production passkey',
                'callback' => 'http://example.com/callback?secret=some_secret_hash_key',
            ]
        ],
    ]
];
