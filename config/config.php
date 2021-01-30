<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Mode
    |--------------------------------------------------------------------------
    |
    | By default, this setting will be false. When disabled all interactions
    | with the Alpaca Trading API (not the data API) will be performed against
    | the paper trading API instead of the live one.
    |
    */
    'live_trading' => env('ALPACA_LIVE_TRADING', false),

    /*
    |--------------------------------------------------------------------------
    | Live Base URL
    |--------------------------------------------------------------------------
    |
    | Specify which API to consume for Live Trading.
    |
    */
    'live_base_url' => env('ALPACA_LIVE_BASE_URL', 'https://api.alpaca.markets/v2'),

    /*
    |--------------------------------------------------------------------------
    | Paper Base URL
    |--------------------------------------------------------------------------
    |
    | Specify which API to consume for Paper Trading.
    |
    */
    'paper_base_url' => env('ALPACA_PAPER_BASE_URL', 'https://paper-api.alpaca.markets/v2'),

    /*
    |--------------------------------------------------------------------------
    | Data Base URL
    |--------------------------------------------------------------------------
    |
    | Specify which API to consume for getting market data.
    |
    */
    'data_base_url' => env('ALPACA_DATA_BASE_URL', 'https://data.alpaca.markets/v1'),

    /*
    |--------------------------------------------------------------------------
    | API Secret Key
    |--------------------------------------------------------------------------
    |
    | The Secret Key tokens should be kept confidential and only stored on your
    | own servers. This key will be used to preform all actions on your behalf
    | through all of Alpaca's APIs.
    |
    */
    'secret_key' => env('ALPACA_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | API Key ID
    |--------------------------------------------------------------------------
    |
    | Your API Key ID is what is used to identify your account, like a username.
    | This should also be kept confidential in order to keep your account
    | secure.
    |
    */
    'key_id' => env('ALPACA_KEY_ID')
];
