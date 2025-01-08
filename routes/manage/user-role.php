<?php
use iProtek\Xrac\Http\Controllers\XuserRoleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;
use \iProtek\Xrac\Helpers\XracHelper;


    Route::prefix('user-role')->name('.user-role')->group(function(){
        Route::get('role-info/{branch_id}/{app_account_id}', [XuserRoleController::class, 'role_info'])->name('.role-info');
        Route::post('set-branch-role', [XuserRoleController::class, 'set_user_branch_role_allowed'])->name('.set-branch-role');
    });
 