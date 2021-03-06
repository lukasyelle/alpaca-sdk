<?php

namespace Lukasyelle\AlpacaSdk\Tests\Orders;

use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidData;
use Lukasyelle\AlpacaSdk\Orders\ListOrders;
use Lukasyelle\AlpacaSdk\Tests\BaseTestCase;

class ListOrdersTest extends BaseTestCase
{
    protected string $mockResponse = '[{
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
    },{
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
    }]';

    private ListOrders $api;

    protected function getAlpacaApiType(): string
    {
        return AlpacaTrading::class;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = new ListOrders($this->mockClient);
    }

    /** @test */
    public function itShouldListOrders()
    {
        $response = $this->api->get();

        $this->assertSame('/v2/orders', $this->api->endpoint);
        $this->assertSame('/v2/orders', $this->getLastRequestUri()->getPath());
        $this->assertSame('paper-api.alpaca.markets', $this->getLastRequestUri()->getHost());

        $this->assertSameSize($this->expectedResult(), $response);
    }

    /** @test */
    public function itShouldAddOpenStatusFlag()
    {
        $this->api->open()->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('status=open', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddClosedStatusFlag()
    {
        $this->api->closed()->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('status=closed', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddAllStatusFlags()
    {
        $this->api->all()->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertStringContainsString('status=all', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddLimitFlag()
    {
        $this->api->take(10)->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('limit=10', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldFailTakingMoreThan500()
    {
        $this->expectException(InvalidData::class);

        $this->api->take(501)->get();
    }

    /** @test */
    public function itShouldAddAfterFlag()
    {
        $this->api->after(0)->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('after=0', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddUntilFlag()
    {
        $this->api->until(0)->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('until=0', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddDirectionAscFlag()
    {
        $this->api->asc()->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('direction=asc', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddDirectionDescFlag()
    {
        $this->api->desc()->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('direction=desc', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddNestedFlag()
    {
        $this->api->nested()->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('nested=1', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddSingleSymbolToSymbolsFlag()
    {
        $this->api->whereSymbol('AAPL')->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('symbols=AAPL', $lastUri->getQuery());
    }

    /** @test */
    public function itShouldAddMultipleSymbolsToSymbolsFlag()
    {
        $this->api->whereSymbols(['AAPL', 'AMD', 'GME'])->get();

        $lastUri = $this->getLastRequestUri();
        $this->assertSame('symbols=AAPL%2CAMD%2CGME', $lastUri->getQuery());
    }

    /** @test */
    public function itCanListOrdersThroughFacade()
    {
        \Lukasyelle\AlpacaSdk\Facades\Orders\ListOrders::shouldReceive('get')->once()->andReturn($this->expectedResult());

        \Lukasyelle\AlpacaSdk\Facades\Orders\ListOrders::get();
    }
}
