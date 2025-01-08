<?php

namespace iProtek\Xrac\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iProtek\Xrac\Models\XuserRole;

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
}
