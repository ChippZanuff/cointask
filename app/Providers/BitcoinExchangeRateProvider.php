<?php

namespace App\Providers;

use App\Repositories\BitcoinRepositoryInterface;
use App\Repositories\BlockchainRepository;
use App\Repositories\CoindeskRepository;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Config;

class BitcoinExchangeRateProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if(\config('app.bitcoin_exchange_rate_provider_name') == 'blockchain'){
            $this->app->bind(BitcoinRepositoryInterface::class, function() {
                return $this->app->make(BlockchainRepository::class);
            });
        }
        if(\config('app.bitcoin_exchange_rate_provider_name') == 'coindesk'){
            $this->app->bind(BitcoinRepositoryInterface::class, function() {
                return app(CoindeskRepository::class);
            });
        }
    }
}
