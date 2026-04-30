<?php
use iProtek\Xrac\Http\Controllers\XroleController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;
use Illuminate\Support\Facades\DB;


Route::prefix('xrole')->name('.xrole')->group(function(){

    Route::middleware(['can:menu-xrole'])->get('/', [ XroleController::class, 'index'])
        ->defaults("_description", "Role Index View")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.index');

    Route::middleware(['can:menu-xrole'])->get('/user-role-access', [ XroleController::class, 'user_role_access'])
        ->defaults("_description", "User Role Access")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.user-role-access');

    Route::get('/shared-account-list', function(Request $request){return XracPayHttp::app_user_account("", 1, 10);})
        ->defaults("_description", "list of account that has access")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.shared-account-list');

    /*
    Route::get('/send-invite', function(Request $request){
        return XracPayHttp::send_invitation($request->email, $request->role, "1234");
    })->name('.send-invite');
    */

    Route::get('menus', function(Request $request){
            return DB::table('sys_sidemenu_items')->get();
        })
        ->defaults("_description", "Menu List")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.menus');


    Route::get('role-menus/{role_id}', function(Request $request, $role_id = 0){
            $role_menus = [];
            if(!$request->role_id)return;

            if(!is_numeric($role_id)) return;

            $role_id = $role_id * 1;

            $menus = DB::table('sys_sidemenu_items')->get();
            foreach($menus as $menu){ 
                $user_types = explode(',', $menu->user_types);
                $role_menus[] = [
                    "id"=>$menu->id,
                    "menu_text"=>$menu->menu_text,
                    "is_allowed"=>in_array(  $role_id ,$user_types)
                ];

            }
            return $role_menus;
        })
        ->defaults("_description", "Role Menu List")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.role-menu');


    Route::post('update-role-menu/{role_id}', function(Request $request, $role_id){

            if(!$role_id || $role_id == "0") return;

            $menu_ids = $request->menu_ids;
            $menus = DB::table('sys_sidemenu_items')->get();

            foreach($menus as $menu){ 
                $userTypes = explode(',',$menu->user_types);
                if(in_array($menu->id, $menu_ids)){
                    //ADD USERTYPE IF NOT EXISTS
                    if(!in_array($role_id, $userTypes)){
                        $userTypes[] = $role_id;
                        DB::table('sys_sidemenu_items')
                        ->where('id', $menu->id)->update(["user_types"=>implode(",", $userTypes)]);
                    }
                }else{
                    //REMOVE USER ROLE
                    $userTypes = array_diff($userTypes, [$role_id]);
                    DB::table('sys_sidemenu_items')
                    ->where('id', $menu->id)
                    ->update(["user_types"=>implode(",", $userTypes)]);
                }

            }

            return ["status"=>1, "message"=>"Successfully updated."];
        })
        ->defaults("_description", "Update the menu of the role")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.update-menu');


    Route::get('/account-list', function(Request $request){
            $page = $request->page ?: 1;
            $exact = $request->exact ?: "";
            return  XracPayHttp::app_accounts($request->search, $page, 10, $exact);
        })
        ->defaults("_description", "List of account")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", false)
        ->name('.account-list');

});
