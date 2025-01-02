<?php
use iProtek\Xrac\Http\Controllers\XroleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;


Route::prefix('xrole')->name('.xrole')->group(function(){

    Route::get('/', [ XroleController::class, 'index' ])->name('.index');
    Route::get('/user-role-access', [ XroleController::class, 'user_role_access' ])->name('.user-role-access');
    Route::get('/shared-account-list', function(Request $request){
        return XracPayHttp::app_user_account("", 1, 10);
    })->name('.shared-account-list');

    /*
    Route::get('/send-invite', function(Request $request){
        return XracPayHttp::send_invitation($request->email, $request->role, "1234");
    })->name('.send-invite');
    */

    Route::get('/account-list', function(Request $request){
        return  XracPayHttp::app_accounts("", 1, 10);
    })->name('.account-list');

});
