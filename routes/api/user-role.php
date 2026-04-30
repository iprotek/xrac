<?php
use iProtek\Xrac\Http\Controllers\XuserRoleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;
use \iProtek\Xrac\Helpers\XracHelper;


    Route::prefix('user-role')->name('.user-role')->group(function(){

        Route::get('role-info/{branch_id}/{app_account_id}', [XuserRoleController::class, 'role_info'])
            ->defaults("_description", "User role info")
            ->defaults("_is_visible", true)
            ->defaults("_is_allow", false)
            ->name('.role-info');
        Route::post('set-branch-role', [XuserRoleController::class, 'set_user_branch_role_allowed'])
            ->defaults("_description", "Set user role in a branch")
            ->defaults("_is_visible", true)
            ->defaults("_is_allow", false)
            ->name('.set-branch-role');

        Route::get('branch-access-list/{branch_id}', [XuserRoleController::class, 'get_user_branch_role_access'])
            ->defaults("_description", "Get user role and access in a branch")
            ->defaults("_is_visible", true)
            ->defaults("_is_allow", false)
            ->name('.get-branch-user-role-access-list');
    
        Route::post('branch-access-list/{branch_id}', [XuserRoleController::class, 'update_user_branch_role_access'])
            ->defaults("_description", "Update user role and access in a branch")
            ->defaults("_is_visible", true)
            ->defaults("_is_allow", false)
            ->name('.update-branch-user-role-access-list');
    
    });
 