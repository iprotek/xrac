<?php
use iProtek\Xrac\Http\Controllers\XroleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('role')->name('.role')->group(function(){
    Route::get('/active-list', [ XroleController::class, 'active_role_list'])
        ->defaults("_description", "List of active roles")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.active-role-list');

    Route::post('/select-branch', [ XroleController::class, 'select_branch'])
        ->defaults("_description", "Branch selection in a role area")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.select-branch');

    Route::get('/list', [XroleController::class, 'role_list'])
        ->defaults("_description", "Role list")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.list');

    //SYNC BRANCHLIST
    Route::get('/sync-roles', [XroleController::class, 'sync_role_list'])
        ->defaults("_description", "Get role list from sync")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.sync-role');

    //ADD & SYNC
    Route::post('/sync-add', [XroleController::class, 'sync_add'])
        ->defaults("_description", "Sync add role")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.sync-add');

    //UPDATE & SYNC
    Route::post('/sync-update', [XroleController::class, 'sync_update'])
        ->defaults("_description", "Sync update role")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.sync-update');

    //REMOVE & SYNC
    Route::post('/sync-remove', [XroleController::class, 'sync_remove'])
        ->defaults("_description", "Sync remove role")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.sync-remove');
});
