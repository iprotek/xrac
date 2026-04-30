<?php
use iProtek\Xrac\Http\Controllers\XbranchController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('branch')->name('.branch')->group(function(){

    Route::get('/active-list', [XbranchController::class, 'active_branch_list'])
        ->defaults("_description", "List of Active Branches")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.active-list');

    Route::post('/select-branch', [XbranchController::class, 'select_branch'])
        ->defaults("_description", "Branch Selection")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.select');

    Route::get('/list', [XbranchController::class, 'branch_list'])
        ->defaults("_description", "Branch List")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.list');

    //SYNC BRANCHLIST
    Route::get('/sync-branches', [XbranchController::class, 'sync_branch_list'])
        ->defaults("_description", "Synchronize Branches centralize controls")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.sync-branches');

    //ADD & SYNC
    Route::post('/sync-add', [XbranchController::class, 'sync_add'])
        ->defaults("_description", "Add Branch from centralize controls")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.add');

    //UPDATE & SYNC
    Route::post('/sync-update', [XbranchController::class, 'sync_update'])
        ->defaults("_description", "Update branches from centralize controls")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.sync-update');

    //REMOVE & SYNC
    Route::post('/sync-remove', [XbranchController::class, 'sync_remove'])
        ->defaults("_description", "Remove Branch from centralize controls")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.sync-remove');
});
