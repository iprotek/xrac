<?php
use iProtek\Xrac\Http\Controllers\XroleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('branch')->name('.branch')->group(function(){

    Route::get('/list', [ XroleController::class, 'branch_list' ])->name('.branch-list');

    //SYNC BRANCHLIST
    Route::get('/sync-branches', [XroleController::class, 'sync_branch_list'])->name('.sync-branches');

    //ADD & SYNC

    //UPDATE & SYNC

});
