<?php

namespace iProtek\Xrac;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        //DEFINE GATES
        
        Gate::define('menu-xrole', function ($user) {
            if($user->id == 1){
                return true;
            }
            return false;
        });




        // Bootstrap package services
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'iprotek_xrac');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/iprotek.php', 'iprotek_xrac'
        );
    }
}