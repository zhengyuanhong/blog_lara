<?php
namespace App\Utils\Wx;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use XH_Payment_Api;

require_once(__DIR__ . '/../../Helper/WxPay/api.php');

class WxPayment extends Config {
    public function pay($order_param){

        $hashkey =$this->app_secret;
        $data = $this->dataFormat($order_param);
        $data['hash']     = XH_Payment_Api::generate_xh_hash($data,$hashkey);

        try {
            $response = XH_Payment_Api::http_post($this->url, json_encode($data));
            $result = $response?json_decode($response,true):null;
            if(!$result){
                throw new Exception('Internal server error',500);
            }

            $hash = XH_Payment_Api::generate_xh_hash($result,$hashkey);
            if(!isset( $result['hash'])|| $hash!=$result['hash']){
                throw new Exception(__('Invalid sign!',XH_Wechat_Payment),40029);
            }

            if($result['errcode']!=0){
                throw new Exception($result['errmsg'],$result['errcode']);
            }

            return $result;
        } catch (Exception $e) {
            echo "errcode:{$e->getCode()},errmsg:{$e->getMessage()}";
            //TODO:处理支付调用异常的情况
        }
    }

    public function notify($data,$callback){
        Log::info('notify :'.Auth::id());
        Log::info('notify $data=',[$data]);
        foreach ($data as $k=>$v){
            $data[$k] = stripslashes($v);
        }
        if(!isset($data['hash'])||!isset($data['trade_order_id'])){
            Log::info('pay faild for 1 user_id:'.Auth::id());
            return false;
        }

        //自定义插件ID,请与支付请求时一致
        if(isset($data['plugins'])&&$data['plugins']!=$this->my_plugin_id){
            Log::info('pay faild for 2 user_id:'.Auth::id());
            return false;
        }

        //APP SECRET
        $appkey =$this->app_secret;
        $hash =XH_Payment_Api::generate_xh_hash($data,$appkey);
        if($data['hash']!=$hash){
            //签名验证失败
            Log::info('pay faild for 3 user_id:'.Auth::id());
            return false;
        }

//商户订单ID
//        $trade_order_id =$data['trade_order_id'];
//
//        if($data['status']=='OD'){
//            /************商户业务处理******************/
//            //TODO:此处处理订单业务逻辑,支付平台会多次调用本接口(防止网络异常导致回调失败等情况)
//            //     请避免订单被二次更新而导致业务异常！！！
//            //     if(订单未处理){
//            //         处理订单....
//            //      }
//            Log::info('success OD'.Auth::id().'::'.$trade_order_id);
//            //....
//            //...
//            /*************商户业务处理 END*****************/
//        }else{
//            //处理未支付的情况
//            Log::info('un success OD'.Auth::id().'::'.$trade_order_id);
//        }

        call_user_func($callback,$data);
        //以下是处理成功后输出，当支付平台接收到此消息后，将不再重复回调当前接口
        return true;
    }
}
