<?php

namespace iProtek\Xrac\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iProtek\Xrac\Models\XcontrolAccessDefault;

class XcontrolAccessDefaultController extends Controller
{
    //
    //
    public function allow_role_access_list(Request $request, $role_id){

        $defaults = XcontrolAccessDefault::where(["xrole_id"=>$role_id, "is_allow"=>true])->get();
        return $defaults;
    }

    public function update_allow_role_access(Request $request, $role_id){
        
        if(!$role_id || $role_id == "0") return;

        $accessList = $request->allow_access_list;

        //UPDATE DEFAULT ROLE ACCESS ID
        XcontrolAccessDefault::where(["xrole_id"=>$role_id])->update(["is_allow"=>false]);


        foreach($accessList as $access){
            $roleAccess = XcontrolAccessDefault::where([ "xrole_id"=>$role_id, 'xcontrol_access_id'=> $access])->first();
            if($roleAccess){
                $roleAccess->update(["is_allow"=>true]);
            }else{
                XcontrolAccessDefault::create([
                    "xrole_id"=>$role_id,
                    "xcontrol_access_id"=>$access,
                    "is_allow"=>true,
                    "app_id"=>0,
                    "data"=>"{}",
                    "is_active"=>true,
                    "cstyle"=>"",
                    "group_id"=>0
                ]);

            }
        }

        return ["status"=>1, "message"=>"Successfully updated"];
    }
}
