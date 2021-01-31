<?php

namespace Lukasyelle\AlpacaSdk;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Lukasyelle\AlpacaSdk\Contracts\AlpacaMarketData;
use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidConfig;

class AlpacaSdkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('alpaca-sdk.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'alpaca-sdk');

        $this->bindClient(AlpacaMarketData::class);
        $this->bindClient(AlpacaTrading::class);
    }

    private function bindClient(string $class)
    {
        $this->app->bind($class, function () use ($class) {
            $config = config('alpaca-sdk');

            $this->guardAgainstInvalidConfig($config);

            $baseUri = match ($class) {
                // Determine which API to use.
                AlpacaTrading::class => $config['live_trading'] ? $config['live_base_url'] : $config['paper_base_url'],
                AlpacaMarketData::class => $config['data_base_url']
            };

            $guzzle = new Client([
                'base_uri' => $baseUri,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'APCA-API-KEY-ID' => $config['key_id'],
                    'APCA-API-SECRET-KEY' => $config['secret_key'],
                ],
            ]);

            return new \Lukasyelle\AlpacaSdk\Client($guzzle);
        });

    }

    /**
     * @param  array|null  $config
     */
    protected function guardAgainstInvalidConfig(array $config = null): void
    {
        if (empty($config['data_base_url'])) {
            throw InvalidConfig::baseUrlNotSpecified('Data');
        }

        if (empty($config['paper_base_url'])) {
            throw InvalidConfig::baseUrlNotSpecified('paper');
        }

        if (empty($config['live_base_url'])) {
            throw InvalidConfig::baseUrlNotSpecified('live');
        }

        if (empty($config['key_id'])) {
            throw InvalidConfig::apiKeyNotSpecified();
        }

        if (empty($config['secret_key'])) {
            throw InvalidConfig::apiKeyNotSpecified();
        }
    }
}