<?php

namespace iProtek\Core\Xrac\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iProtek\Xrac\Models\XuserRole;

class XuserRoleController extends Controller
{
    //

    public function get(Request $request, $branch_id, $app_account_id){
        return XuserRole::where([
            "branch_id"=>$branch_id,
            "app_account_id"=>$app_account_id
        ])->get();
    }
}
