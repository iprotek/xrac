<?php


namespace iProtek\Xrac\Helpers;

use iProtek\Core\Helpers\PayHttp;
use iProtek\Core\Models\UserAdminPayAccount;


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
    public static function client($token=null){
        //Preparation of Headers
        $pay_url = config('iprotek.pay_url');
        $client_id = config('iprotek.pay_client_id');
        $client_secret = config('iprotek.pay_client_secret'); 
        $system_id = config('iprotek.system_id');
 

        $proxy_id = 0;
        $pay_app_user_account_id = 0;
        
        if(auth()->check()){
            $user = auth()->user();
            $pay_account = \iProtek\Core\Models\UserAdminPayAccount::where('user_admin_id', $user->id)->first();
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
        //PRECHECKING
        $client = static::client(); 
        $response = $client->get($url);
        return $response;
    }

    public static function post_client($url, $body, $raw_response = true){

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