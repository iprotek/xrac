<?php

namespace iProtek\Xrac\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iProtek\Xrac\Models\XuserRole;
use iProtek\Xrac\Models\XcontrolAccessDefault;
use iProtek\Xrac\Models\XuserCustomRoleAccess;


class XuserRoleController extends Controller
{
    //

    public function role_info(Request $request, $branch_id, $app_account_id){
        $userRole = XuserRole::where([
            "branch_id"=>$branch_id,
            "app_account_id"=>$app_account_id
        ])->first();
        if(!$userRole){
            return json_decode('{}');
        }
        return $userRole;
    }

    public function set_user_branch_role_allowed(Request $request){
        $branch_id = $request->branch_id; 
        $app_account_id = $request->app_account_id;
        $is_allowed = $request->is_allowed ? true : false;
        $userRole = XuserRole::where([
            "branch_id"=>$branch_id,
            "app_account_id"=>$app_account_id
        ])->first();
        if($userRole){
            $userRole->is_allowed = $is_allowed;
            $userRole->save();
        }else{
            $userRole = XuserRole::create([
                "app_account_id"=>$app_account_id,
                "is_allowed"=>$is_allowed,
                "xrole_id"=>-1,
                "is_default"=>true,
                "app_id"=>0,
                "branch_id"=>$branch_id,
                "group_id"=>0
            ]);
        }

        return ["status"=>1, "message"=>"User allowed set.", "user_role"=>$userRole];

    }

    public function get_user_branch_role_access(Request $request, $branch_id){

        $role_id = $request->role_id;
        $app_account_id = $request->app_account_id;
        $is_default = $request->is_default;
        $is_default_force = $request->is_default_force;

        $userRole = XuserRole::where([ "app_account_id"=>$app_account_id, "branch_id"=>$branch_id])->first();
        if(!$userRole){
            $defaults = XcontrolAccessDefault::where(["xrole_id"=>$role_id, "is_allow"=>true])->get();
            return $defaults;
        }
        else if($is_default_force && $userRole->xrole_id != $role_id){
            $defaults = XcontrolAccessDefault::where(["xrole_id"=>$role_id, "is_allow"=>true])->get();
            return $defaults;
        }
        else if( $is_default && $is_default == 1 ){
            //GET DEFAULT BY ROLE
            $defaults = XcontrolAccessDefault::where(["xrole_id"=>$role_id, "is_allow"=>true])->get();
            return $defaults;
        }
        else if($userRole && $userRole->xrole_id == $role_id){

        }
        $customs = XuserCustomRoleAccess::where([
            "branch_id"=>$branch_id,
            "app_account_id"=>$app_account_id,
            "is_allow"=>true
        ])->get();
        return $customs;

    }

    public function update_user_branch_role_access(Request $request, $branch_id){
        //role_id
        //app_account_id
        //accessIds
        //is_default
        $role_id = $request->role_id;
        $app_account_id = $request->app_account_id;
        $accessIds = $request->accessIds ?? [];
        $is_default = $request->is_default ? true : false;

        //UPDATE USER IF DEFAULT OR NOT 
        $userRole = XuserRole::where([ "app_account_id"=>$app_account_id, "branch_id"=>$branch_id])->first();
        if($userRole ){
            $userRole->xrole_id = $role_id;
            $userRole->is_default = $is_default;
            $userRole->save();
        }else{
            $userRole = XuserRole::create([
                "xrole_id"=>$role_id,
                "app_account_id"=>$app_account_id,
                "is_default"=>$is_default,
                "branch_id"=>$branch_id,
                "group_id"=>0
            ]);
        } 

        //UPDATE ACCESSLIST FOR CUSTOMIZATION OF ACCESS
        if(!$is_default){
            //CLEAN ALL CUSTOMS OF APP_ACCOUNT AND USEROLE
            XuserCustomRoleAccess::where([
                "branch_id"=>$branch_id,
                "app_account_id"=>$app_account_id
            ])->update([
                "is_allow"=>false
            ]);

            //ADDING OR UPDATING CUSTOMIZED ACCESS
            foreach($accessIds as $access_id){
                $customRole = XuserCustomRoleAccess::where([
                    "branch_id"=>$branch_id,
                    "app_account_id"=>$app_account_id,
                    "xcontrol_access_id"=>$access_id
                ])->first();
                if($customRole){
                    $customRole->xrole_id = $role_id;
                    $customRole->is_allow = true;
                    $customRole->save();
                }else{
                    XuserCustomRoleAccess::create([
                        "xrole_id"=>$role_id,
                        "branch_id"=>$branch_id,
                        "app_account_id"=>$app_account_id,
                        "xcontrol_access_id"=>$access_id,
                        "is_allow"=>true,
                        "app_id"=>0,
                        "group_id"=>0
                    ]);
                }
            }
        }
        return ["status"=>1, "message"=>"Successfully updated."];
    }
}
