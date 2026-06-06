<?php

use Illuminate\Support\Facades\Route; 
use iProtek\PolicyControl\Http\Controllers\PolicyControlController;


Route::prefix('policy-control')->name('.policy-control')->group(function(){

    Route::get('list', [PolicyControlController::class, 'list'])->name('.list')
        ->defaults("_description", "List of policy control")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false);

    Route::post('update-role', [PolicyControlController::class, 'update_role'])->name('.update-role')
        ->defaults("_description", "Update role access to policy control")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false);

    Route::post('update-user-disable-routes', [PolicyControlController::class, 'update_user_disable_routes'])->name('.update-user-disable-routes')
        ->defaults("_description", "Update user disable routes access to policy control")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false);

    Route::get('role-routes/{xrole_id}', [PolicyControlController::class, 'get_role_routes'])->name('.get-role-routes')
        ->defaults("_description", "Get role access to policy control")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false);

    Route::get('user-disable-routes/{app_account_id}', [PolicyControlController::class, 'get_user_disable_routes'])->name('.get-user-disable-routes')
        ->defaults("_description", "Get user disable routes access to policy control")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false);


});