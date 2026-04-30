<?php
use iProtek\Xrac\Http\Controllers\XroleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('role')->name('.role')->group(function(){
    Route::get('/active-list', [ 
        "uses"=>[ XroleController::class, 'active_role_list'],
        "description"=>"List of active roles",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.active-role-list');

    Route::post('/select-branch', [ 
        "uses"=>[ XroleController::class, 'select_branch'],
        "description"=>"Branch selection in a role area",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.select-branch');

    Route::get('/list', [ 
        "uses"=>[XroleController::class, 'role_list'],
        "description"=>"Role list",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.list');

    //SYNC BRANCHLIST
    Route::get('/sync-roles', [ 
        "uses"=>[XroleController::class, 'sync_role_list'],
        "description"=>"Get role list from sync",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.sync-role');

    //ADD & SYNC
    Route::post('/sync-add', [ 
        "uses"=>[XroleController::class, 'sync_add'],
        "description"=>"Sync add role",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.sync-add');

    //UPDATE & SYNC
    Route::post('/sync-update', [
        "uses"=>[XroleController::class, 'sync_update'],
        "description"=>"Sync update role",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.sync-update');

    //REMOVE & SYNC
    Route::post('/sync-remove', [
        "uses"=>[XroleController::class, 'sync_remove'],
        "description"=>"Sync remove role",
        "is_visible"=>true,
        "is_allow"=>false
    ])->name('.sync-remove');
});
