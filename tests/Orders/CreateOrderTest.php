<?php

namespace Lukasyelle\AlpacaSdk\Tests\Orders;

use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidData;
use Lukasyelle\AlpacaSdk\Orders\CreateOrder;
use Lukasyelle\AlpacaSdk\Orders\Order;
use Lukasyelle\AlpacaSdk\Tests\BaseTestCase;

class CreateOrderTest extends BaseTestCase
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

    private array $orderData = [
        "client_order_id" => "904837e3-3b76-47ec-b432-046db621571b",
        "symbol" => "AAPL",
        "qty" => "15",
        "type" => "market",
        "side" => "buy",
        "time_in_force" => "day",
        "limit_price" => "107.00",
        "stop_price" => "106.00",
        "status" => "accepted",
        "extended_hours" => false,
        "legs" => null,
        "trail_price" => "1.05",
        "trail_percent" => null,
    ];
    
    protected function getAlpacaApiType(): string
    {
        return AlpacaTrading::class;
    }


    public function anOrderObjectShouldBeCreated()
    {
        $api = new CreateOrder($this->mockClient, $this->orderData);

        $this->assertIsObject($api->order, 'Order object was not created');
        $this->assertStringContainsString(Order::class, get_class($api->order));
        $this->assertSameSize($this->orderData, $api->order->toArray());
    }

    /** @test */
    public function itShouldSetProperRequestFields()
    {
        $api = new CreateOrder($this->mockClient, $this->orderData);

        $this->assertIsArray($api->bodyParams, 'Body Params should be an array');
        $this->assertSameSize($api->bodyParams, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfLimitPriceNullForLimitOrder()
    {
        $this->orderData['type'] = 'limit';
        $this->orderData['limit_price'] = null;

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfLimitPriceNullForStopLimitOrder()
    {
        $this->orderData['type'] = 'stop_limit';
        $this->orderData['limit_price'] = null;

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfStopPriceNullForStopOrder()
    {
        $this->orderData['type'] = 'stop';
        $this->orderData['stop_price'] = null;

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfStopPriceNullForStopLimitOrder()
    {
        $this->orderData['type'] = 'stop_limit';
        $this->orderData['stop_price'] = null;

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfLimitPriceNotSetForLimitOrder()
    {
        $this->orderData['type'] = 'limit';
        unset($this->orderData['limit_price']);

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfLimitPriceNotSetForStopLimitOrder()
    {
        $this->orderData['type'] = 'stop_limit';
        unset($this->orderData['limit_price']);

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfStopPriceNotSetForStopOrder()
    {
        $this->orderData['type'] = 'stop';
        unset($this->orderData['stop_price']);

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfStopPriceNotSetForStopLimitOrder()
    {
        $this->orderData['type'] = 'stop_limit';
        unset($this->orderData['stop_price']);

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfTrailPriceAndTrailPercentNullForTrailingStopOrder()
    {
        $this->orderData['type'] = 'trailing_stop';
        $this->orderData['trail_price'] = null;
        $this->orderData['trail_percent'] = null;

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfTrailPriceAndTrailPercentNotSetForTrailingStopOrder()
    {
        $this->orderData['type'] = 'trailing_stop';
        unset($this->orderData['trail_price']);
        unset($this->orderData['trail_percent']);

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfTakeProfitNullForTakeProfitPropertyOfAdvancedOrder()
    {
        $this->orderData['take_profit'] = null;

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfLimitPriceNotSetForTakeProfitPropertyOfAdvancedOrder()
    {
        $this->orderData['take_profit'] = [];

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfLimitPriceNullForTakeProfitPropertyOfAdvancedOrder()
    {
        $this->orderData['take_profit'] = [
            'limit_price' => null
        ];

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfStopLossNullForStopLossPropertyOfAdvancedOrder()
    {
        $this->orderData['stop_loss'] = null;

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfStopPriceNotSetForStopLossPropertyOfAdvancedOrder()
    {
        $this->orderData['stop_loss'] = [];

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function anInvalidDataExceptionShouldBeThrownIfLimitPriceNullForStopLossPropertyOfAdvancedOrder()
    {
        $this->orderData['stop_loss'] = [
            'stop_price' => null
        ];

        $this->expectException(InvalidData::class);

        new CreateOrder($this->mockClient, $this->orderData);
    }

    /** @test */
    public function itCanCreateOrdersThroughFacade()
    {
        \Lukasyelle\AlpacaSdk\Facades\Orders\CreateOrder::shouldReceive('from')->once()->andReturn($this->expectedResult());

        \Lukasyelle\AlpacaSdk\Facades\Orders\CreateOrder::from($this->orderData);
    }
}