<?php
namespace App\Utils;

use Illuminate\Support\Facades\Log;

require_once(__DIR__.'/../Helper/WeBo/saetv.php');

class WeiBoLogin{
    public $handle;
    public $redirect_url;
    public function __construct(){
        $this->handle = new \SaeTOAuthV2(config('util.wei_bo.client_id'),config('util.wei_bo.client_secret'));
    }

    public function getAuthorizeURL(){
        return $this->handle->getAuthorizeURL(config('util.wei_bo.redirect_url'));
    }

    public function getAccessToken($code){
        $keys = [];
        $keys['code'] = $code;
        $keys['redirect_uri'] = config('util.wei_bo.redirect_url');
        try{
            $token =  $this->handle->getAccessToken('code',$keys);
            return $token;
        }catch (\Exception $e){
           Log::error('微博授权失败.'.$e->getMessage());
        }
    }

    public function getUid($access_token){
        $uid =  $this->handle->get(config('util.wei_bo.user_id_api'),['access_token'=>$access_token]);
        return $uid['uid'];
    }

    public function getWeBoUserInfo($access_token,$uid){
        return $this->handle->get('https://api.weibo.com/2/users/show.json',array('access_token'=>$access_token,'uid'=>$uid));
    }
}
