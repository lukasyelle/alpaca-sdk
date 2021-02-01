# Quick Start

Although the SDK can be used in a standalone application with composer, it works best when it is included with a Laravel application.

## Installation

You can install the package via composer:

```bash
composer require lukasyelle/alpaca-sdk
```

## Basic Composer Project Usage 

Obtain your Secret Key and Key ID from the Alpaca Dashboard.
```php
$keyId = 'vakmMcxnAjJNTTvMhIUU';
$secretKey = 'vakmMcxnAjJNTTvMhIUUYXeAZcwTbkZjRdYIbmum';

$liveApiBaseUrl = 'https://api.alpaca.markets';
$paperApiBaseUrl = 'https://paper-api.alpaca.markets';
$dataApiBaseUrl = 'https://data.alpaca.markets';
```

The SDK makes it easy to interact with all the Alpaca APIs. 

```php
$liveTradingClient = new \Lukasyelle\AlpacaSdk\Clients\TradingClient($liveApiBaseUrl, $keyId, $secretKey);
$paperTradingClient = new \Lukasyelle\AlpacaSdk\Clients\TradingClient($paperApiBaseUrl, $keyId, $secretKey);
$marketDataClient = new \Lukasyelle\AlpacaSdk\Clients\MarketDataClient($dataApiBaseUrl, $keyId, $secretKey);
```

The above clients can now be used as a dependency for communicating with various endpoints. for example, to call the `account` endpoint -

```php
use Lukasyelle\AlpacaSdk\Account\Details;

$account = new Details($liveTradingClient);
$response = $account->get();

print_r($response);
```

All endpoints that return data will return data as a `\Illuminate\Support\Collection`. This will provide various utility methods when searching the response. For more information on Laravel Collections see [https://laravel.com/docs/6.x/collections](https://laravel.com/docs/6.x/collections).

```php
Collection {#275 ▼
  #items: array:7 [▼
    "account_blocked" => false,
    "account_number" => "010203ABCD",
    "buying_power" => "262113.632",
    "cash" => "-23140.2",
    "created_at" => "2019-06-12T22:47:07.99658Z",
    "currency" => "USD",
    "daytrade_count" => 0,
    "daytrading_buying_power" => "262113.632",
    "equity" => "103820.56",
    "id" => "e6fe16f3-64a4-4921-8928-cadf02f92f98",
    "initial_margin" => "63480.38",
    "last_equity" => "103529.24",
    "last_maintenance_margin" => "38000.832",
    "long_market_value" => "126960.76",
    "maintenance_margin" => "38088.228",
    "multiplier" => "4",
    "pattern_day_trader" => false,
    "portfolio_value" => "103820.56",
    "regt_buying_power" => "80680.36",
    "short_market_value" => "0",
    "shorting_enabled" => true,
    "sma" => "0",
    "status" => "ACTIVE",
    "trade_suspended_by_user" => false,
    "trading_blocked" => false,
    "transfers_blocked" => false,
  ]
}
```

## Laravel Usage

The SDK comes with a Laravel Service Provider to facilitate a much cleaner and streamlined setup. The SDK will only work with Laravel 5.8 and above and as such the package will automatically register the provider and the facades.

You can publish the config file of this package with this command:

``` bash
php artisan vendor:publish --provider="Lukasyelle\AlpacaSdk\AlpacaSdkServiceProvider"
```

The following [config](config/config.php) file will be published in `config/alpaca-sdk.php`

Once you have installed the package, configure your `.env` with the following keys setting the correct values for your account. When you are ready to start consuming the Live Trading API instead of the Paper Trading one, you can enable the 'ALPACA_LIVE_TRADING' setting.

```bash
ALPACA_LIVE_TRADING=false
ALPACA_KEY_ID=vakmMcxnAjJNTTvMhIUU
ALPACA_SECRET_KEY=vakmMcxnAjJNTTvMhIUUYXeAZcwTbkZjRdYIbmum
```

By default, the SDK will pass all trading requests through the paper trading API. Set the live trading environment variable to ```true``` to start using your actual brokerage account.

#### Application container

The Application container will automatically resolve the correct `Alpaca Client` dependencies for you when calling any endpoint. Which means you can just type hint your endpoint to retrieve the object from the container with all configurations in place.

```php
use \Lukasyelle\AlpacaSdk\Account\Details;

// From a constructor
class FooClass {
    public function __construct(Details $account) {
       $response = $account->get();
    }
}

// From a method
class BarClass {
    public function barMethod(Details $account) {
       $response = $account->get();
    }
}
```

Alternatively you may use the provided facades directly. This provides a much faster and fluent interface to the various endpoints.

```php
use \Lukasyelle\AlpacaSdk\Facades\Account\Details;

$response = Details::get();
```

Some endpoints require extra parameters being passed to the endpoint object. Please see each endpoint documentation for requirements and example usage.
