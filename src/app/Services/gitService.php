<?php
namespace App\Services;

use GuzzleHttp\Client;
use Log;
use App\Models\User;

/**
 * 
 * 
 * @author shoubin@iscas.ac.cn
 *
 */
class GitService
{
    function __construct(){
        $this->git_secret = config("app.git_secret");
        $this->api_host = config("app.git_api_host") ;
        $this->api = new Client([
            //根域名
            'base_uri'  => $this->api_host,
            // 超时
            'timeout'   => 5.0,
            'verify'    => false,
            'headers'   =>  [
                'PRIVATE-TOKEN'  => $this->git_secret
            ],
        ]);
        Log::debug('app.git_secret: ' . $this->git_secret);
        Log::debug('app.$api_host: '  . $this->api_host);
    }
    
    function getUselist() {
       
        $res = $this->api->get("users");
        $ret =  $res->getBody();
        Log::debug($ret);
        $data = (json_decode($ret));
        return  $data; 
    }
    function  getUserInfo($userId){
        $res = $this->api->get("users/".$userId);
        $ret =  $res->getBody();
        Log::debug($ret);
        $data = json_decode($ret);
        return  $data;
    }
}

?>