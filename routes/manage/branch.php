<?php
use iProtek\Xrac\Http\Controllers\XroleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('branch')->name('.branch')->group(function(){

    Route::get('/active-list', [ XroleController::class, 'active_branch_list' ])->name('.branch-list');

    Route::post('/select-branch', [ XroleController::class, 'select_branch' ])->name('.select-branch');

    Route::get('/list', [ XroleController::class, 'branch_list' ])->name('.branch-list');

    //SYNC BRANCHLIST
    Route::get('/sync-branches', [XroleController::class, 'sync_branch_list'])->name('.sync-branches');

    //ADD & SYNC
    Route::post('/sync-add', [XroleController::class, 'sync_add'])->name('.sync-add');

    //UPDATE & SYNC
    Route::post('/sync-update', [XroleController::class, 'sync_update'])->name('.sync-update');

    //REMOVE & SYNC
    Route::post('/sync-remove', [XroleController::class, 'sync_remove'])->name('.sync-remove');
});
