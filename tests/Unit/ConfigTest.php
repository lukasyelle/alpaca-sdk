<?php

namespace Lukasyelle\AlpacaSdk\Tests\Unit;

use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidConfig;
use Lukasyelle\AlpacaSdk\Facades\Account\Details;
use Lukasyelle\AlpacaSdk\Tests\BaseTestCase;

class ConfigTest extends BaseTestCase
{
    private string $api = AlpacaTrading::class;

    protected function getAlpacaApiType(): string
    {
        return $this->api;
    }

    /** @test */
    public function itFailsWithEmptySecretKey()
    {
        $this->app['config']->set('alpaca-sdk.secret_key', '');

        $this->expectException(InvalidConfig::class);

        Details::get();
    }

    /** @test */
    public function itFailsWithEmptyKeyID()
    {
        $this->app['config']->set('alpaca-sdk.key_id', '');

        $this->expectException(InvalidConfig::class);

        Details::get();
    }

    /** @test */
    public function itFailsWithEmptyPaperBaseUrl()
    {
        $this->app['config']->set('alpaca-sdk.paper_base_url', '');

        $this->expectException(InvalidConfig::class);

        Details::get();
    }

    /** @test */
    public function itFailsWithEmptyLiveBaseUrl()
    {
        $this->app['config']->set('alpaca-sdk.live_base_url', '');

        $this->expectException(InvalidConfig::class);

        Details::get();
    }

    /** @test */
    public function itFailsWithEmptyLiveDataUrl()
    {
        $this->app['config']->set('alpaca-sdk.data_base_url', '');

        $this->expectException(InvalidConfig::class);

        Details::get();
    }
}
