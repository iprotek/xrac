<?php

namespace iProtek\Xrac\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iProtek\Core\Http\Controllers\_Common\_CommonOwnGroupController; 
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Xrac\Helpers\XracData;
use iProtek\Xrac\Models\Xrole;

class XroleController extends _CommonOwnGroupController
{
    //
    public $guard = 'admin';

    public function index(Request $request){

        return $this->view('iprotek_xrac::manage.xrole');

    }
    public function active_role_list(Request $request){

        $active_roles = Xrole::where('is_active', 1);
        return
        [
            "list"=>  $active_roles->get()
        ];
    }
 
    public function user_role_access(Request $request){
        return $this->view('iprotek_xrac::manage.xuser-role-access');
    }

    public function role_list(Request $request){
        
        return Xrole::get();
    }


    public function sync_role_list(Request $request){

        //GET DATA FROM SERVER
        $data = XracData::ApiXracRoles();
        //return $data;

        if($data["status"] != 1){
            return ["status"=>0, "message"=>"Something goes wrong with the API"];
        }
        $api_rolees = $data["roles"];
        $api_role_ids = [];
        foreach($api_rolees as $api_br){
            $api_role_ids[] = $api_br['local_role_id'];
        }


        //COMPARE IF EXISTS THEN ADD IF POSSIBLE
        $local_roles = Xrole::withTrashed()->get();
        $local_role_ids = $local_roles->pluck('id')->toArray();

        //ADDING FROM API TO LOCAL
        $api_diff_ids = array_diff($api_role_ids, $local_role_ids);
        foreach($api_rolees as $api_role){
            if(in_array($api_role['local_role_id'] *1, $api_diff_ids)){
                //LOCAL DUE TO ID UPDATE
                if(!Xrole::withTrashed()->find($api_role['local_role_id'])){ 
                    \DB::table('xroles')->insert([
                        "id"=>$api_role['local_role_id']*1,
                        "name"=>$api_role['name'],
                        "is_active"=>$api_role['is_active'],
                        "group_id"=>"0",
                        "deleted_at"=> $api_role['deleted_at'] ? substr($api_role['deleted_at'], 0, 20) : null,
                        "pay_created_by"=>$api_role['created_pay_user_account_id'],
                        "pay_updated_by"=>$api_role['updated_pay_user_account_id'],
                        "pay_deleted_by"=>$api_role['deleted_pay_user_account_id'],
                        "data"=>$api_role['default_data']
                    ]);
                }
            }
        }/**/

        //ADDING FROM LOCAL To API
        $local_diff_ids = array_diff( $local_role_ids, $api_role_ids);
        foreach($local_roles as $local_role){
            if( in_array($local_role->id, $local_diff_ids) ){
                $result = XracData::ApiXracRoleAddUpdate([
                    "role_id"=>$local_role->id,
                    "name"=>$local_role->name,
                    "is_active"=>$local_role->is_active,
                    "deleted_at"=>$local_role->deleted_at ? substr($local_role->deleted_at, 0, 20) : null,
                    "description"=>$local_role->description,
                    "default_data"=>$local_role->data
                ]);
                return $result;
            }
        }/**/

        return ["status"=>1, "message"=>"Done syncing", "api_role_ids"=>$api_role_ids, "local_role_ids"=>$local_role_ids , "api_diffs"=>$api_diff_ids, "local_diffs"=>$local_diff_ids];
    }

    public function sync_add(Request $request){

        $data = $this->validate($request, [
            "name"=>"required|unique:xroles,name",
            "is_active"=>"nullable",
            "data"=>"nullable",
            "address"=>"nullable",
            "description"=>"nullable"
        ])->validated();

        $data["group_id"] = 0;
        $data['title'] = $request->name;

        $role = Xrole::create($data);


        $result = XracData::ApiXracRoleAddUpdate([
            "local_id"=>$role->id,
            "name"=>$role->name,
            "is_active"=>$role->is_active,
            "deleted_at"=>$role->deleted_at ? substr($role->deleted_at, 0, 20) : null
        ]);

        return ["status"=>1, "message"=>"Role added.", "role"=>$role];
    }

    public function sync_update(Request $request){

        $data = $this->validate($request, [
            "id"=>"required",
            "name"=>"required|unique:xroles,name,".$request->id,
            "is_active"=>"nullable",
            "data"=>"nullable",
            "address"=>"nullable"
        ])->validated();
        
        $data["group_id"] = 0;
        $data['title'] = $request->name;

        $role = Xrole::find($data['id']);
        if(!$role){
            return ["status"=>0, "message"=>"Role not found." ]; 
        }
        $role->update($data);

        $result = XracData::ApiXracRoleAddUpdate([
            "role_id"=>$role->id,
            "name"=>$role->name,
            "is_active"=>$role->is_active,
            "deleted_at"=>$role->deleted_at ? substr($role->deleted_at, 0, 20) : null,
            "default_data"=>$role->data,
            "description"=>$role->description
        ]);
        return ["status"=>1, "message"=>"Role updated."];
    }

    
    public function sync_remove(Request $request){

        $data = $this->validate($request, [
            "id"=>"required"
        ])->validated();

        $role = Xrole::find($data['id']);
        if(!$role){
            return ["status"=>0, "message"=>"Role Not found"];
        }
        $role->delete();
        $trashRole = Xrole::withTrashed()->find($data['id']); 

        //SYNC TO PAY
        $result = XracData::ApiXracRoleAddUpdate([
            "role_id"=>$trashRole->id,
            "name"=>$trashRole->name,
            "is_active"=>$trashRole->is_active,
            "deleted_at"=>$trashRole->deleted_at ? substr($role->deleted_at, 0, 20) : null,
            "description"=>$trashRole->description,
            "default_data"=>$trashRole->data
        ]); 
        return $result;

        return ["status"=>1, "message"=>"Role removed."];
    }

}
