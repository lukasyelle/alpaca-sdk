<?php

namespace Lukasyelle\AlpacaSdk;

use Illuminate\Support\ServiceProvider;
use Lukasyelle\AlpacaSdk\Clients\MarketDataClient;
use Lukasyelle\AlpacaSdk\Clients\TradingClient;
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
     *
     * @throws InvalidConfig
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'alpaca-sdk');

        $this->app->bind(AlpacaTrading::class, function () {
            $config = config('alpaca-sdk');
            $this->guardAgainstInvalidConfig($config);
            $baseUrl = $config['live_trading'] ? $config['live_base_url'] : $config['paper_base_url'];

            return new TradingClient($baseUrl, $config['key_id'], $config['secret_key']);
        });

        $this->app->bind(AlpacaMarketData::class, function () {
            $config = config('alpaca-sdk');
            $this->guardAgainstInvalidConfig($config);

            return new MarketDataClient($config['data_base_url'], $config['key_id'], $config['secret_key']);
        });
    }

    /**
     * @param array|null $config
     */
    protected function guardAgainstInvalidConfig(array $config = null): void
    {
        if (empty($config['data_base_url'])) {
            throw InvalidConfig::baseUrlNotSpecified('data');
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
