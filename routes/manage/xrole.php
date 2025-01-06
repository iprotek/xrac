<?php
use iProtek\Xrac\Http\Controllers\XroleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;
use Illuminate\Support\Facades\DB;


Route::prefix('xrole')->name('.xrole')->group(function(){

    Route::middleware(['can:menu-xrole'])->get('/', [ XroleController::class, 'index' ])->name('.index');
    Route::middleware(['can:menu-xrole'])->get('/user-role-access', [ XroleController::class, 'user_role_access' ])->name('.user-role-access');
    Route::get('/shared-account-list', function(Request $request){
        return XracPayHttp::app_user_account("", 1, 10);
    })->name('.shared-account-list');

    /*
    Route::get('/send-invite', function(Request $request){
        return XracPayHttp::send_invitation($request->email, $request->role, "1234");
    })->name('.send-invite');
    */

    Route::get('menus', function(Request $request){
        return DB::table('sys_sidemenu_items')->get();
    })->name('.menus');
    Route::get('/account-list', function(Request $request){
        $page = $request->page ?: 1;
        return  XracPayHttp::app_accounts($request->search, $page, 10);
    })->name('.account-list');

});
