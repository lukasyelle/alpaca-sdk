<?php

namespace Lukasyelle\AlpacaSdk\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Lukasyelle\AlpacaSdk\AlpacaSdkServiceProvider;
use Lukasyelle\AlpacaSdk\Clients\MarketDataClient;
use Lukasyelle\AlpacaSdk\Clients\TradingClient;
use Lukasyelle\AlpacaSdk\Contracts\Alpaca;
use Lukasyelle\AlpacaSdk\Contracts\AlpacaMarketData;
use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidConfig;
use Lukasyelle\AlpacaSdk\Facades\Account\Account;
use Orchestra\Testbench\TestCase;
use Psr\Http\Message\UriInterface;

abstract class BaseTestCase extends TestCase
{
    protected int $mockResponseCode = 200;

    protected string $mockResponse = '';

    protected Alpaca $mockClient;

    protected MockHandler $handler;

    protected string $alpacaApi = '';

    /**
     * @return string A class path reference to an Alpaca Contract
     */
    abstract protected function getAlpacaApiType(): string;

    /**
     * @param $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [AlpacaSdkServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('alpaca-sdk.live_trading', false);
        $app['config']->set('alpaca-sdk.live_base_url', 'https://api.alpaca.markets');
        $app['config']->set('alpaca-sdk.paper_base_url', 'https://paper-api.alpaca.markets');
        $app['config']->set('alpaca-sdk.data_base_url', 'https://data.alpaca.markets');
        $app['config']->set('alpaca-sdk.secret_key', 'vakmMcxnAjJNTTvMhIUUYXeAZcwTbkZjRdYIbmum');
        $app['config']->set('alpaca-sdk.key_id', 'vakmMcxnAjJNTTvMhIUU');
    }

    protected function getPackageAliases($app)
    {
        return [
            'Account' => Account::class,
        ];
    }

    /**
     * @throws InvalidConfig
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockClient = $this->getMockClient();
    }

    protected function getLastRequestUri(): UriInterface
    {
        return $this->handler->getLastRequest()->getUri();
    }

    protected function getBaseUri(): string
    {
        $config = $this->app['config'];

        return match ($this->getAlpacaApiType()) {
            // Determine which API to use.
            AlpacaTrading::class    => $config['alpaca-sdk.live_trading'] ? $config['alpaca-sdk.live_base_url'] : $config['alpaca-sdk.paper_base_url'],
            AlpacaMarketData::class => $config['alpaca-sdk.data_base_url'],
        };
    }

    protected function createClient($baseUrl, $keyId, $secretKey, $handlerStack): AlpacaMarketData | AlpacaTrading
    {
        return match($this->getAlpacaApiType()) {
            AlpacaTrading::class    => new TradingClient($baseUrl, $keyId, $secretKey, $handlerStack),
            AlpacaMarketData::class => new MarketDataClient($baseUrl, $keyId, $secretKey, $handlerStack),
        };
    }

    protected function mockResponse(): Response
    {
        return new Response($this->mockResponseCode, [], $this->mockResponse);
    }

    protected function expectedResult(): Collection
    {
        return new Collection(json_decode($this->mockResponse));
    }

    protected function getMockClient(): AlpacaTrading | AlpacaMarketData
    {
        $handler = new MockHandler([
            $this->mockResponse(),
        ]);

        $this->handler = $handler;
        $handlerStack = HandlerStack::create($handler);

        $config = $this->app['config'];
        $baseUri = $this->getBaseUri();

        return $this->createClient($baseUri, $config['alpaca-sdk.key_id'], $config['alpaca-sdk.secret_key'], $handlerStack);
    }
}
