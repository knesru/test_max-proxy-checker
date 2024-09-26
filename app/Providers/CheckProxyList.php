<?php

namespace App\Providers;

use App\Http\Controllers\ProxyCheckerController;
use App\Services\CheckProxiesService;
use App\Services\IpStack;
use Illuminate\Support\ServiceProvider;

class CheckProxyList extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProxyCheckerController::class, function ($app) {
            return new ProxyCheckerController($app->make(CheckProxiesService::class));
        });

        $this->app->bind(CheckProxiesService::class, function ($app) {
            return new CheckProxiesService($app->make(IpStack::class));
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
