<?php
use iProtek\Xrac\Http\Controllers\XbranchController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('branch')->name('.branch')->group(function(){

    Route::get('/active-list', [ 
        "uses"=> [XbranchController::class, 'active_branch_list'],
        "description"=>"List of Active Branches",
        "is_visible"=>true,
        "is_allow"=>false
     ])->name('.active-list');

    Route::post('/select-branch', [ 
        "uses"=>[XbranchController::class, 'select_branch'],
        "description"=>"Branch Selection",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.select');

    Route::get('/list', [ 
        "uses"=>[XbranchController::class, 'branch_list'],
        "description"=>"Branch List",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.list');

    //SYNC BRANCHLIST
    Route::get('/sync-branches', [
        "uses"=>[XbranchController::class, 'sync_branch_list'],
        "description"=>"Synchronize Branches centralize controls",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.sync-branches');

    //ADD & SYNC
    Route::post('/sync-add', [
        "uses"=>[XbranchController::class, 'sync_add'],
        "description"=>"Add Branch from centralize controls",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.add');

    //UPDATE & SYNC
    Route::post('/sync-update', [
        "uses"=>[XbranchController::class, 'sync_update'],
        "description"=>"Update branches from centralize controls",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.sync-update');

    //REMOVE & SYNC
    Route::post('/sync-remove', [
        "uses"=>[XbranchController::class, 'sync_remove'],
        "description"=>"Remove Branch from centralize controls",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.sync-remove');
});
