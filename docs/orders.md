# Orders

## List

Used to List all past and current orders on your Alpaca account.

#### Basic Composer Project Example

```php
use Lukasyelle\AlpacaSdk\Clients\TradingClient;
use Lukasyelle\AlpacaSdk\Orders\ListOrders;

$client = new TradingClient($baseUrl, $keyId, $secretKey);
$endpoint = new ListOrders($client);
$response = $endpoint->get();
```
#### Laravel Equivalent
```php
use Lukasyelle\AlpacaSdk\Facades\Orders\ListOrders;

$response = ListOrders::get();
```

**Response**


```php
Collection {#275 ▼
  #items: array:7 [▼
    [
        "id": "904837e3-3b76-47ec-b432-046db621571b",
        "client_order_id": "904837e3-3b76-47ec-b432-046db621571b",
        "created_at": "2018-10-05T05:48:59Z",
        "updated_at": "2018-10-05T05:48:59Z",
        "submitted_at": "2018-10-05T05:48:59Z",
        "filled_at": "2018-10-05T05:48:59Z",
        "expired_at": "2018-10-05T05:48:59Z",
        "canceled_at": "2018-10-05T05:48:59Z",
        "failed_at": "2018-10-05T05:48:59Z",
        "replaced_at": "2018-10-05T05:48:59Z",
        "replaced_by": "904837e3-3b76-47ec-b432-046db621571b",
        "replaces": null,
        "asset_id": "904837e3-3b76-47ec-b432-046db621571b",
        "symbol": "AAPL",
        "asset_class": "us_equity",
        "qty": "15",
        "filled_qty": "0",
        "type": "market",
        "side": "buy",
        "time_in_force": "day",
        "limit_price": "107.00",
        "stop_price": "106.00",
        "filled_avg_price": "106.00",
        "status": "accepted",
        "extended_hours": false,
        "legs": null,
        "trail_price": "1.05",
        "trail_percent": null,
        "hwm": "108.05"
    ],[
        "id": "904837e3-3b76-47ec-b432-046db621571b",
        "client_order_id": "904837e3-3b76-47ec-b432-046db621571b",
        "created_at": "2018-10-05T05:48:59Z",
        "updated_at": "2018-10-05T05:48:59Z",
        "submitted_at": "2018-10-05T05:48:59Z",
        "filled_at": "2018-10-05T05:48:59Z",
        "expired_at": "2018-10-05T05:48:59Z",
        "canceled_at": "2018-10-05T05:48:59Z",
        "failed_at": "2018-10-05T05:48:59Z",
        "replaced_at": "2018-10-05T05:48:59Z",
        "replaced_by": "904837e3-3b76-47ec-b432-046db621571b",
        "replaces": null,
        "asset_id": "904837e3-3b76-47ec-b432-046db621571b",
        "symbol": "AAPL",
        "asset_class": "us_equity",
        "qty": "15",
        "filled_qty": "0",
        "type": "market",
        "side": "buy",
        "time_in_force": "day",
        "limit_price": "107.00",
        "stop_price": "106.00",
        "filled_avg_price": "106.00",
        "status": "accepted",
        "extended_hours": false,
        "legs": null,
        "trail_price": "1.05",
        "trail_percent": null,
        "hwm": "108.05",
    ]
  ]
}
```

#### API Documentation

The ListOrders class exposes several methods which allow for setting the same flags that are present within the [Alpaca 
API](https://alpaca.markets/docs/api-documentation/api-v2/orders/) in a fluent manner. These methods are all available 
in the provided Facade for Laravel use cases as well as the class for default composer project usage. The following 
examples will assume usage from within a Laravel application. 

* ```php 
  ListOrders::closed()->get(); // Add the status=closed flag to the api request.
  ```
* ```php 
  ListOrders::open()->get(); // Add the status=open flag to the api request.
  ```
* ```php 
  ListOrders::all()->get(); // Add the status=all and limit=500 flags to the api request.
  ```
* ```php 
  ListOrders::take(5)->get(); // Add the limit=5 flag to the api request.
  ```
* ```php 
  ListOrders::after($timestamp)->get(); // Add the after=$timestamp flag to the api request.
  ```
* ```php 
  ListOrders::until($timestamp)->get(); // Add the until=$timestamp flag to the api request.
  ```
* ```php 
  ListOrders::asc()->get(); // Add the direction=asc flag to the api request.
  ```
* ```php 
  ListOrders::desc()->get(); // Add the direction=desc flag to the api request.
  ```
* ```php 
  ListOrders::nested()->get(); // Add the nested=1 flag to the api request.
  ```
* ```php 
  ListOrders::whereSymbol('AAPL')->get(); // Add the symbols=AAPL flag to the api request.
  ```
* ```php 
  ListOrders::whereSymbols(['AAPL', 'AMD'])->get(); // Add the symbols=AAPL%2CAMD flag to the api request.
  ```

## Create

Used to create a new order, or replace an existing one.


#### Basic Composer Project Example

```php
use Lukasyelle\AlpacaSdk\Clients\TradingClient;
use Lukasyelle\AlpacaSdk\Orders\CreateOrder;

$orderData = [
    'client_order_id' => 'whatever-you-want-unique',
    'symbol'          => 'AAPL',
    'qty'             => '15',
    'type'            => 'market',
    'side'            => 'buy',
    'time_in_force'   => 'day',
    'limit_price'     => '107.00',
    'stop_price'      => '106.00',
    'status'          => 'accepted',
    'extended_hours'  => false,
    'legs'            => null,
    'trail_price'     => '1.05',
    'trail_percent'   => null,
];

$client = new TradingClient($baseUrl, $keyId, $secretKey);
$endpoint = new CreateOrder($orderData);
$response = $endpoint->get();
```
#### Laravel Equivalent
```php
use Lukasyelle\AlpacaSdk\Facades\Orders\CreateOrder;

$response = CreateOrder::from($orderData);
```
#### Order Object Convenience Method

The SDK provides an Order Object that provides parameter validation as well as convenience methods to the above Facade. If you already have an Order object, these methods are a more fluent way to interact with the API. 

**Note: These Helper Methods Assume You're Using A Laravel App**. They utilize Facades under the hood.

```php
use Lukasyelle\AlpacaSdk\Orders\Order;

$response = (new Order($orderData))->create();
```


#### Replace An Order

You can replace an order by providing an order ID to any of the above create order methods as a second (or third) parameter.

Alternatively, you can also use the dedicated replace method on an Order object.

```php 
$replaceOrderId = 'reference-to-the-id-on-the-order-object-to-replace';
$response = (new Order($orderData))->replace($replaceOrderId);
```

Or use the Facade as shown below:
```php
$response = \Lukasyelle\AlpacaSdk\Facades\Orders\CreateOrder::replaceOrder($replaceOrderId)->with($orderData);
```

**Response**

```php
Collection {#275 ▼
  #items: array:7 [▼
    "id": "904837e3-3b76-47ec-b432-046db621571b",
    "client_order_id": "whatever-you-want-unique",
    "created_at": "2021-01-05T05:48:59Z",
    "updated_at": "2021-01-05T05:48:59Z",
    "submitted_at": "2021-01-05T05:48:59Z",
    "filled_at": "2021-01-05T05:48:59Z",
    "expired_at": "2021-01-05T05:48:59Z",
    "canceled_at": "2021-01-05T05:48:59Z",
    "failed_at": "2021-01-05T05:48:59Z",
    "replaced_at": "2021-01-05T05:48:59Z",
    "replaced_by": "904837e3-3b76-47ec-b432-046db621571b",
    "replaces": null,
    "asset_id": "904837e3-3b76-47ec-b432-046db621571b",
    "symbol": "AAPL",
    "asset_class": "us_equity",
    "qty": "15",
    "filled_qty": "0",
    "type": "market",
    "side": "buy",
    "time_in_force": "day",
    "limit_price": "107.00",
    "stop_price": "106.00",
    "filled_avg_price": "106.00",
    "status": "accepted",
    "extended_hours": false,
    "legs": null,
    "trail_price": "1.05",
    "trail_percent": null,
    "hwm": "108.05"
  ]
}
```