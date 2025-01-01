<?php

namespace iProtek\Xrac;

use Illuminate\Support\ServiceProvider;

class XracPackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register package services
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap package services
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'iprotek_xrac');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/iprotek.php', 'iprotek_xrac'
        );
    }
}