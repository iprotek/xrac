<?php

namespace iProtek\Xrac;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use iProtek\Core\Helpers\BranchSelectionHelper;
use iProtek\Core\Helpers\PayHttp;
use iProtek\Xrac\Models\XuserRole;
use iProtek\Core\Helpers\UserMenuHelper;

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
            // Check if user has menu-xrole at systemmenu and check its role and its user and in a specific branch
            return UserMenuHelper::userHasMenu($user, 'menu-xrole');
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