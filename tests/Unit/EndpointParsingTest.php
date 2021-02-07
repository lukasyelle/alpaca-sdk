<?php

namespace Lukasyelle\AlpacaSdk\Tests\Unit;

use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Orders\GetOrder;
use Lukasyelle\AlpacaSdk\Orders\ListOrders;
use Lukasyelle\AlpacaSdk\Tests\BaseTestCase;

class EndpointParsingTest extends BaseTestCase
{
    protected function getAlpacaApiType(): string
    {
        return AlpacaTrading::class;
    }

    /** @test */
    public function itReturnsBasicStrings()
    {
        $api = new ListOrders($this->mockClient);

        $this->assertEquals($api->endpoint, $api->getFullEndpoint());
    }

    /** @test */
    public function itSubstitutesKeys()
    {
        $api = new GetOrder($this->mockClient);

        $orderId = 'asdf1234asdf';
        $api->setOrderId($orderId);

        $this->assertEquals("/v2/orders/$orderId", $api->getFullEndpoint());
    }

    /** @test */
    public function itSubstitutesMultipleKeys()
    {
        $api = new GetOrder($this->mockClient);

        $orderId = 'asdf1234asdf';
        $api->setOrderId($orderId);

        $api->test = 'replaced';
        $api->endpoint = $api->endpoint.'/{test}';

        $this->assertEquals('/v2/orders/asdf1234asdf/replaced', $api->getFullEndpoint());
    }

    /** @test */
    public function itDoesntSubstituteKeysThatAreNotPropertiesOfTheRequest()
    {
        $api = new ListOrders($this->mockClient);
        $api->endpoint = $api->endpoint.'/{noReplace}';

        $this->assertEquals('/v2/orders/{noReplace}', $api->getFullEndpoint());
    }
}
