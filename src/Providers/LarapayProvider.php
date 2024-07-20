<?php

namespace Nusagates\Larapay\Providers;

use Illuminate\Support\ServiceProvider;
use Nusagates\Larapay\Providers\IpaymuServiceProvider;

/**
 * @author Cak Bud <budairi@leap.id>
 */
class LarapayProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(IpaymuServiceProvider::class);

        $configPath = __DIR__ . '/../../config/larapay.php';
        $this->mergeConfigFrom($configPath, 'larapay');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $configPath = __DIR__ . '/../../config/larapay.php';
        $this->publishes([
            $configPath => config_path('larapay.php')
        ], 'larapay-config');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
