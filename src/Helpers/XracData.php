<?php


namespace iProtek\Xrac\Helpers;

use iProtek\Core\Helpers\PayHttp;
use iProtek\Core\Models\UserAdminPayAccount;
use iProtek\Xrac\Helpers\XracPayHttp;


class XracData
{
    public static function ApiXracBranches(){
        
        $response = XracPayHttp::get_client("app-user-account/xrac/branches/list?is_all=yes");
        $response_code = $response->getStatusCode();
        $pay_branches = json_decode($response->getBody(), true); 
        if($response_code<200 || $response_code>203){
            return [ "status"=>0, "branches"=>[],"message"=>$pay_branches, "status_code"=>$response_code];
        }
        return [ "status"=>1, "branches"=>$pay_branches];

    }

    public static function ApiXracBranchAddUpdate(array $data){
        
        $response = XracPayHttp::post_client("app-user-account/xrac/branches/add-update", $data);
        $response_code = $response->getStatusCode();
        $result = json_decode($response->getBody(), true); 
        if($response_code<200 || $response_code>203){
            return [ "status"=>0, "branches"=>[],"message"=>$result, "status_code"=>$response_code];
        }
        return $result;
        //return [ "status"=>1, "message"=>"Successfully Added"];
    }


}