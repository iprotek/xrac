<?php

namespace iProtek\Xrac\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iProtek\Core\Http\Controllers\_Common\_CommonOwnGroupController;
use iProtek\Core\Models\Branch;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Xrac\Helpers\XracData;

class XroleController extends _CommonOwnGroupController
{
    //
    public $guard = 'admin';

    public function index(Request $request){

        return $this->view('iprotek_xrac::manage.xrole');

    }

    public function user_role_access(Request $request){
        return $this->view('iprotek_xrac::manage.xuser-role-access');
    }

    public function branch_list(Request $request){
        
        $branches = Branch::on();

        if($request->search){
            $search = '%'.str_replace(' ', '%', $request->search).'%';
            $branches->whereRaw('name like ?', [$search]);
        }

        return $branches->paginate(10);
    }

    public function sync_branch_list(Request $request){

        //GET DATA FROM SERVER
        $data = XracData::ApiXracBranches();

        if($data["status"] != 1){
            return ["status"=>0, "message"=>"Something goes wrong with the API"];
        }
        $api_branches = $data["branches"];
        $api_branch_ids = [];
        foreach($api_branches as $api_br){
            $api_branch_ids[] = $api_br['local_branch_id'];
        }


        $local_branches = Branch::get();
        //COMPARE IF EXISTS THEN ADD IF POSSIBLE
        $local_branch_ids = $local_branches->pluck('id')->toArray();

        //ADDING FROM API TO LOCAL
        $api_diff_ids = array_diff($api_branch_ids, $local_branch_ids);
        foreach($api_branches as $api_branch){
            if(in_array($api_branch['local_branch_id'] *1, $api_diff_ids)){
                //LOCAL DUE TO ID UPDATE
                if(!Branch::find($api_branch['local_branch_id'])){
                    \DB::table('branches')->insert([
                        "id"=>$api_branch['local_branch_id']*1,
                        "name"=>$api_branch['name'],
                        "is_active"=>$api_branch['is_active'],
                        "group_id"=>"0"
                    ]);
                }
            }
        }/**/

        //ADDING FROM LOCAL To API
        $local_diff_ids = array_diff( $local_branch_ids, $api_branch_ids);
        foreach($local_branches as $local_branch){
            if( in_array($local_branch->id, $local_diff_ids) ){
                $result = XracData::ApiXracBranchAddUpdate([
                    "branch_id"=>$local_branch->id,
                    "name"=>$local_branch->name,
                    "is_active"=>$local_branch->is_active
                ]);
            }
        }/**/

        return ["status"=>1, "message"=>"Done syncing", "api_branch_ids"=>$api_branch_ids, "local_branch_ids"=>$local_branch_ids , "api_diffs"=>$api_diff_ids, "local_diffs"=>$local_diff_ids];
    }

}
