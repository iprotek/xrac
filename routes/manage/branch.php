<?php
use iProtek\Xrac\Http\Controllers\XbranchController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('branch')->name('.branch')->group(function(){

    Route::get('/active-list', [ XbranchController::class, 'active_branch_list' ])->name('.active-branch-list');

    Route::post('/select-branch', [ XbranchController::class, 'select_branch' ])->name('.select-branch');

    Route::get('/list', [ XbranchController::class, 'branch_list' ])->name('.branch-list');

    //SYNC BRANCHLIST
    Route::get('/sync-branches', [XbranchController::class, 'sync_branch_list'])->name('.sync-branches');

    //ADD & SYNC
    Route::post('/sync-add', [XbranchController::class, 'sync_add'])->name('.sync-add');

    //UPDATE & SYNC
    Route::post('/sync-update', [XbranchController::class, 'sync_update'])->name('.sync-update');

    //REMOVE & SYNC
    Route::post('/sync-remove', [XbranchController::class, 'sync_remove'])->name('.sync-remove');
});
