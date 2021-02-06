<?php

namespace Lukasyelle\AlpacaSdk\Tests\Orders;

use Illuminate\Support\Collection;
use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Orders\GetOrder;
use Lukasyelle\AlpacaSdk\Orders\Order;
use Lukasyelle\AlpacaSdk\Tests\BaseTestCase;

class GetOrderTest extends BaseTestCase
{
    protected string $mockResponse = '{
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
    }';

    protected function getAlpacaApiType(): string
    {
        return AlpacaTrading::class;
    }

    /** @test*/
    public function itGetsOrders()
    {
        $api = new GetOrder($this->mockClient);

        $orderId = '904837e3-3b76-47ec-b432-046db621571b';
        $api->setOrderId($orderId);

        $order = $api->get();

        $this->assertEquals("/v2/orders/$orderId", $api->getFullEndpoint());
        $this->assertInstanceOf(Collection::class, $order);
        $this->assertSameSize($this->expectedResult(), $order);
    }

    /** @test*/
    public function itSetsIdFromConstructor()
    {
        $orderId = '904837e3-3b76-47ec-b432-046db621571b';
        $api = new GetOrder($this->mockClient, $orderId);

        $order = $api->get();

        $this->assertEquals("/v2/orders/$orderId", $api->getFullEndpoint());
        $this->assertInstanceOf(Collection::class, $order);
        $this->assertSameSize($this->expectedResult(), $order);
    }

    /** @test */
    public function itGetsOrderThroughFacade()
    {
        \Lukasyelle\AlpacaSdk\Facades\Orders\GetOrder::shouldReceive('setOrderId')->once()->andReturnSelf();
        \Lukasyelle\AlpacaSdk\Facades\Orders\GetOrder::shouldReceive('get')->once()->andReturn($this->expectedResult());

        $orderId = '904837e3-3b76-47ec-b432-046db621571b';
        $order = \Lukasyelle\AlpacaSdk\Facades\Orders\GetOrder::setOrderId($orderId)->get();
        $this->assertInstanceOf(Collection::class, $order);
        $this->assertSameSize($this->expectedResult(), $order);
    }

    /** @test */
    public function itGetsOrderThroughOrderClassAlias()
    {
        $order = Order::get('904837e3-3b76-47ec-b432-046db621571b', $this->mockClient);

        $this->assertInstanceOf(Collection::class, $order);
        $this->assertSameSize($this->expectedResult(), $order->toArray());
    }
}