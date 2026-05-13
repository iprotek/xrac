<?php

use Illuminate\Support\Facades\Route; 
use iProtek\PolicyControl\Http\Controllers\PolicyControlController;


Route::prefix('policy-control')->name('.policy-control')->group(function(){
    Route::get('list', [PolicyControlController::class, 'list'])->name('.list')
        ->defaults("_description", "List of policy control")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false);
});