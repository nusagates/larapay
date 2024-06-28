<?php

namespace Nusagates\Larapay\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * @author Cak Bud <budairi@leap.id>
 */
class LarapayProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}