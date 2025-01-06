<?php

namespace iProtek\Xrac\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iProtek\Core\Http\Controllers\_Common\_CommonOwnGroupController;
use iProtek\Core\Models\Branch;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Xrac\Helpers\XracSyncData;
use iProtek\Core\Helpers\BranchSelectionHelper;

class XbranchController extends _CommonOwnGroupController
{
    //
    public $guard = 'admin';

    public function index(Request $request){

        return $this->view('iprotek_xrac::manage.xrole');

    }

    public function select_branch(Request $request){

        //TODO:: Many need requirement such as permission on this metthod and also allowed branch which the user have access

        if(BranchSelectionHelper::disable_multi_branch()){
            return ["status"=>0,  "message"=>"Branch Selection Disabled."];
        }

        if(!$request->branch_id){
            return ["status"=>0, "message"=>"Successfully removed."];
        }
        $branch_id = $request->branch_id*1;

        BranchSelectionHelper::set($branch_id);
        return ["status"=>1,  "message"=>"Successfully Set Branch"];
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

    public function active_branch_list(Request $request){

        $selected_branch = BranchSelectionHelper::get();
        return
        [
            "disable_multi_branch"=>BranchSelectionHelper::disable_multi_branch(),
            "selected_id"=>$selected_branch,
            "list"=> BranchSelectionHelper::disable_multi_branch() ? [] : BranchSelectionHelper::active_branches() //$branches->get()
        ];
    }

    public function sync_branch_list(Request $request){

        //GET DATA FROM SERVER
        $data = XracSyncData::ApiXracBranches();
        //return $data;

        if($data["status"] != 1){
            return ["status"=>0, "message"=>"Something goes wrong with the API"];
        }
        $api_branches = $data["branches"];
        $api_branch_ids = [];
        foreach($api_branches as $api_br){
            $api_branch_ids[] = $api_br['local_branch_id'];
        }


        //COMPARE IF EXISTS THEN ADD IF POSSIBLE
        $local_branches = Branch::withTrashed()->get();
        $local_branch_ids = $local_branches->pluck('id')->toArray();

        //ADDING FROM API TO LOCAL
        $api_diff_ids = array_diff($api_branch_ids, $local_branch_ids);
        foreach($api_branches as $api_branch){
            if(in_array($api_branch['local_branch_id'] *1, $api_diff_ids)){
                //LOCAL DUE TO ID UPDATE
                if(!Branch::withTrashed()->find($api_branch['local_branch_id'])){ 
                    \DB::table('branches')->insert([
                        "id"=>$api_branch['local_branch_id']*1,
                        "name"=>$api_branch['name'],
                        "is_active"=>$api_branch['is_active'],
                        "group_id"=>"0",
                        "deleted_at"=> $api_branch['deleted_at'] ? substr($api_branch['deleted_at'], 0, 20) : null,
                        "pay_created_by"=>$api_branch['created_pay_user_account_id'],
                        "pay_updated_by"=>$api_branch['updated_pay_user_account_id'],
                        "pay_deleted_by"=>$api_branch['deleted_pay_user_account_id']
                    ]);
                }
            }
        }/**/

        //ADDING FROM LOCAL To API
        $local_diff_ids = array_diff( $local_branch_ids, $api_branch_ids);
        foreach($local_branches as $local_branch){
            if( in_array($local_branch->id, $local_diff_ids) ){
                $result = XracSyncData::ApiXracBranchAddUpdate([
                    "branch_id"=>$local_branch->id,
                    "name"=>$local_branch->name,
                    "is_active"=>$local_branch->is_active,
                    "deleted_at"=>$local_branch->deleted_at ? substr($local_branch->deleted_at, 0, 20) : null
                ]);
                //return $result;
            }
        }/**/

        return ["status"=>1, "message"=>"Done syncing", "api_branch_ids"=>$api_branch_ids, "local_branch_ids"=>$local_branch_ids , "api_diffs"=>$api_diff_ids, "local_diffs"=>$local_diff_ids];
    }

    public function sync_add(Request $request){

        $data = $this->validate($request, [
            "name"=>"required|unique:branches,name",
            "is_active"=>"nullable",
            "data"=>"nullable",
            "address"=>"nullable"
        ])->validated();

        $data["group_id"] = 0;

        $branch = Branch::create($data);


        $result = XracSyncData::ApiXracBranchAddUpdate([
            "branch_id"=>$branch->id,
            "name"=>$branch->name,
            "is_active"=>$branch->is_active,
            "deleted_at"=>$branch->deleted_at ? substr($branch->deleted_at, 0, 20) : null
        ]);

        return ["status"=>1, "message"=>"Branch added.", "branch"=>$branch];
    }

    public function sync_update(Request $request){

        $data = $this->validate($request, [
            "id"=>"required",
            "name"=>"required|unique:branches,name,".$request->id,
            "is_active"=>"nullable",
            "data"=>"nullable",
            "address"=>"nullable"
        ])->validated();
        
        $data["group_id"] = 0;

        $branch = Branch::find($data['id']);
        if(!$branch){
            return ["status"=>0, "message"=>"Branch not found." ]; 
        }
        $branch->update($data);

        $result = XracSyncData::ApiXracBranchAddUpdate([
            "branch_id"=>$branch->id,
            "name"=>$branch->name,
            "is_active"=>$branch->is_active,
            "deleted_at"=>$branch->deleted_at ? substr($branch->deleted_at, 0, 20) : null
        ]);

        return ["status"=>1, "message"=>"Branch updated."];
    }

    
    public function sync_remove(Request $request){

        $data = $this->validate($request, [
            "id"=>"required"
        ])->validated();

        $branch = Branch::find($data['id']);
        if(!$branch){
            return ["status"=>0, "message"=>"Branch Not found"];
        }
        $branch->delete();
        $trashBranch = Branch::withTrashed()->find($data['id']); 

        //SYNC TO PAY
        $result = XracSyncData::ApiXracBranchAddUpdate([
            "branch_id"=>$trashBranch->id,
            "name"=>$trashBranch->name,
            "is_active"=>$trashBranch->is_active,
            "deleted_at"=>$trashBranch->deleted_at ? substr($branch->deleted_at, 0, 20) : null
        ]); 

        return ["status"=>1, "message"=>"Branch removed."];
    }

}
