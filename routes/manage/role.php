<?php
use iProtek\Xrac\Http\Controllers\XroleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('role')->name('.role')->group(function(){

    Route::get('/active-list', [ XroleController::class, 'active_role_list' ])->name('.active-role-list');

    Route::post('/select-branch', [ XroleController::class, 'select_branch' ])->name('.select-branch');

    Route::get('/list', [ XroleController::class, 'role_list' ])->name('.branch-list');

    //SYNC BRANCHLIST
    Route::get('/sync-roles', [XroleController::class, 'sync_role_list'])->name('.sync-role');

    //ADD & SYNC
    Route::post('/sync-add', [XroleController::class, 'sync_add'])->name('.sync-add');

    //UPDATE & SYNC
    Route::post('/sync-update', [XroleController::class, 'sync_update'])->name('.sync-update');

    //REMOVE & SYNC
    Route::post('/sync-remove', [XroleController::class, 'sync_remove'])->name('.sync-remove');
});
