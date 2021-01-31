<?php

namespace Lukasyelle\AlpacaSdk\Tests\Account;

use Illuminate\Support\Collection;
use Lukasyelle\AlpacaSdk\Account\Account;
use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Requests\BaseRequest;
use Lukasyelle\AlpacaSdk\Tests\BaseTestCase;

class GetAccountTest extends BaseTestCase
{
    protected string $mockResponse = '{
        "account_blocked": false,
        "account_number": "010203ABCD",
        "buying_power": "262113.632",
        "cash": "-23140.2",
        "created_at": "2019-06-12T22:47:07.99658Z",
        "currency": "USD",
        "daytrade_count": 0,
        "daytrading_buying_power": "262113.632",
        "equity": "103820.56",
        "id": "e6fe16f3-64a4-4921-8928-cadf02f92f98",
        "initial_margin": "63480.38",
        "last_equity": "103529.24",
        "last_maintenance_margin": "38000.832",
        "long_market_value": "126960.76",
        "maintenance_margin": "38088.228",
        "multiplier": "4",
        "pattern_day_trader": false,
        "portfolio_value": "103820.56",
        "regt_buying_power": "80680.36",
        "short_market_value": "0",
        "shorting_enabled": true,
        "sma": "0",
        "status": "ACTIVE",
        "trade_suspended_by_user": false,
        "trading_blocked": false,
        "transfers_blocked": false
    }';

    public function getAlpacaApiType(): string
    {
        return AlpacaTrading::class;
    }

    /**
     * @test
     */
    public function itCanGetAccountInformation()
    {
        $api = new Account($this->mockClient);

        $response = $api->get();

        $this->assertSame('/v2/account', $api->endpoint);
        $this->assertSame('/v2/account', $this->getLastRequestUri()->getPath());
        $this->assertSame('paper-api.alpaca.markets', $this->getLastRequestUri()->getHost());

        $this->assertSameSize($this->expectedResult(), $response);
    }

    /**
     * @test
     */
    public function itCanGetAccountInformationThroughFacade()
    {
        \Lukasyelle\AlpacaSdk\Facades\Account\Account::shouldReceive('get')->once()->andReturn($this->expectedResult());

        \Lukasyelle\AlpacaSdk\Facades\Account\Account::get();
    }
}
