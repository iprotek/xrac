<?php
use iProtek\Xrac\Http\Controllers\XuserRoleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;
use \iProtek\Xrac\Helpers\XracHelper;


    Route::prefix('user-role')->name('.user-role')->group(function(){

        Route::get('role-info/{branch_id}/{app_account_id}', [ 
            "uses"=>[XuserRoleController::class, 'role_info'],
            "description"=>"User role info",
            "is_visible"=>true,
            "is_allow"=>false
        ])->name('.role-info');
        Route::post('set-branch-role', [ 
            "uses"=>[XuserRoleController::class, 'set_user_branch_role_allowed'],
            "description"=>"Set user role in a branch",
            "is_visible"=>true,
            "is_allow"=>false
        ])->name('.set-branch-role');

        Route::get('branch-access-list/{branch_id}', [ "uses"=>[
            XuserRoleController::class, 'get_user_branch_role_access'],
            "description"=>"Get user role and access in a branch",
            "is_visible"=>true,
            "is_allow"=>false
        ])->name('.get-branch-user-role-access-list');
    
        Route::post('branch-access-list/{branch_id}', [ 
            "uses"=>[XuserRoleController::class, 'update_user_branch_role_access'],
            "description"=>"Update user role and access in a branch",
            "is_visible"=>true,
            "is_allow"=>false
        ])->name('.update-branch-user-role-access-list');
    
    });
 