<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class YahooFinanceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/yahoo-finance.php' => config_path('yahoo-finance.php'),
            ], 'config');
        }

        $this->app->singleton(
            YahooFinanceClient::class,
            function () {
                $config = $this->app->get('config');
                $httpClient = new Client([
                    'base_uri' => $config->get('yahoo-finance.apiUrl'),
                    'timeout' => $config->get('yahoo-finance.timeout'),
                    'headers' => [
                        'X-API-KEY' => $config->get('yahoo-finance.apiKey'),
                    ],
                ]);

                return YahooFinanceClient::create($httpClient, $this->app->get(LoggerInterface::class));
            },
        );
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/yahoo-finance.php', 'yahoo-finance');
    }
}
