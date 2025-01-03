<?php


namespace iProtek\Xrac\Helpers;

use iProtek\Core\Helpers\PayHttp;
use iProtek\Core\Models\UserAdminPayAccount;
use Illuminate\Support\Facades\Request;
use iProtek\Core\Helpers\BranchSelectionHelper;


class XracPayHttp
{
    public static function app_accounts($search, $page=1, $items_per_page=10){
        return PayHttp::app_accounts($search, $page, $items_per_page);
    }

    public static function send_invitation($email, $role, $verify_password){
        return PayHttp::send_invitation($email, $role, $verify_password);
    }

    public static function app_user_account($search, $page=1, $items_per_page=""){
        return  PayHttp::app_user_account($search, $page, $items_per_page);
    }
    //AUTH 

    //CLIENT
    public static function client($token=null, $pay_app_user_account_id = null){
        //Preparation of Headers
        $pay_url = config('iprotek.pay_url');
        $client_id = config('iprotek.pay_client_id');
        $client_secret = config('iprotek.pay_client_secret'); 
        $system_id = config('iprotek.system_id');
        if(auth()->check()){
            $branch_id = BranchSelectionHelper::get();
        }else{
            $branch_id = Request::query('branch_id'); 
        }
        $requestor_domain = Request::server('SERVER_NAME');
        $requestor_port = Request::server('SERVER_PORT');
        if(  !$requestor_port || $requestor_port == "80"){

        }else{
            $requestor_domain .= ":".$requestor_port;
        }
 

        $proxy_id = 0;
        $pay_app_user_account_id = PayHttp::pay_account_id();
        
        if(auth()->check()){
            $user = auth()->user();
            $pay_account = \iProtek\Core\Models\UserAdminPayAccount::where('user_admin_id', $user->id)->first();
            if( $pay_account ){ 
                $proxy_id = $pay_account->own_proxy_group_id;
                $pay_app_user_account_id = $pay_account->pay_app_user_account_id;
                $token = $token ?: $pay_account->access_token;
            }
        }else if($pay_app_user_account_id){
            $pay_account = \iProtek\Core\Models\UserAdminPayAccount::where('pay_app_user_account_id', $pay_app_user_account_id)->first();
            if( $pay_account ){ 
                $proxy_id = $pay_account->own_proxy_group_id;
                $pay_app_user_account_id = $pay_account->pay_app_user_account_id;
                $token = $token ?: $pay_account->access_token;
            }
        }


        $headers = [
            "Accept"=>"application/json",
            'Content-Type' => 'application/json',
            "CLIENT-ID"=>$client_id,
            "SECRET"=>$client_secret,
            "PAY-URL"=>$pay_url,
            "SYSTEM-ID"=>$system_id,
            "BRANCH-ID"=>$branch_id,
            "REQUESTOR-DOMAIN"=>$requestor_domain,
            "SOURCE-URL"=>config('app.url'),
            "SOURCE-NAME"=>config('app.name'),
            "PAY-USER-ACCOUNT-ID"=>$pay_app_user_account_id."",
            "PAY-PROXY-ID"=>$proxy_id,
            "Authorization"=>"Bearer ".($token?:"")
        ];
        $client = new \GuzzleHttp\Client([
            'base_uri' => $pay_url,
            "http_errors"=>false, 
            "verify"=>false, 
            "curl"=>[
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0, // Specify HTTP/2
            ],
            "headers"=>$headers
         ]);
        return $client;

    }
    
    public static function get_client( $url ){ 
        //return PayHttp::get_client()
        //PRECHECKING
        $client = static::client(); 
        return $client->get($url); 
    }

    public static function post_client($url, $body){

        if(is_array($body)){
            $body = json_encode($body);
        }
        else if(is_object($body)){
            $body = json_encode($body);
        }

        $client = static::client(); 
        $response = $client->post($url, ["body"=>$body]);
        return $response;
    }

}