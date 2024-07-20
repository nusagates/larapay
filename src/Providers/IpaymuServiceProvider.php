<?php

namespace Nusagates\Larapay\Providers;

use Illuminate\Support\ServiceProvider;
use Nusagates\Larapay\Vendors\iPaymu\Ipaymu;

class IpaymuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Ipaymu::class, function() {
            $config = config('larapay');
            
            return new Ipaymu(
                $config['va'], 
                $config['api_key'], 
                ($config['mode'] == 'production')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
