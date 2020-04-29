<?php

namespace App\Http\Controllers;

use App\Utils\Wx\WxPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use XH_Payment_Api;

class WechatPaymentController extends Controller
{
    public $wx_pay;
    public function __construct(WxPayment $payment)
    {
        $this->wx_pay = $payment;
    }

    public function pay(Request $request)
    {
        //TODO
        $total_fee = $request->get('total_fee',0.01);
        $title = $request->get('title','test');
        $data = [
            'total_fee' =>$total_fee ,//人民币，单位精确到分(测试账户只支持0.1元内付款)
            'title' => $title, //必须的，订单标题，长度32或以内
        ];
        $res = $this->wx_pay->pay($data);
        dd($res);
//        return Response()->json($res);
    }

    public function notify(Request $request){
        $data = $request->all();
        Log::info('notify :'.Auth::id());
        Log::info('notify $data=',[$data]);
        $res = [];
        foreach ($data as $k=>$v){
            $data[$k] = stripslashes($v);
        }
        if(!isset($data['hash'])||!isset($data['trade_order_id'])){
            Log::info('pay faild for 1 user_id:'.Auth::id());
//            return false;
            dd($data);

        }

        //自定义插件ID,请与支付请求时一致
        if(isset($data['plugins'])&&$data['plugins']!=$this->my_plugin_id){
            Log::info('pay faild for 2 user_id:'.Auth::id());
            dd($data);
        }

        //APP SECRET
        $appkey =$this->app_secret;
        $hash =XH_Payment_Api::generate_xh_hash($data,$appkey);
        if($data['hash']!=$hash){
            //签名验证失败
            Log::info('pay faild for 3 user_id:'.Auth::id());
            dd($data);
        }

//商户订单ID
        $trade_order_id =$data['trade_order_id'];

        if($data['status']=='OD'){
            /************商户业务处理******************/
            //TODO:此处处理订单业务逻辑,支付平台会多次调用本接口(防止网络异常导致回调失败等情况)
            //     请避免订单被二次更新而导致业务异常！！！
            //     if(订单未处理){
            //         处理订单....
            //      }
            Log::info('success OD'.Auth::id().'::'.$trade_order_id);
            //....
            //...
            /*************商户业务处理 END*****************/
        }else{
            //处理未支付的情况
            Log::info('un success OD'.Auth::id().'::'.$trade_order_id);
        }
        //以下是处理成功后输出，当支付平台接收到此消息后，将不再重复回调当前接口
        dd($data);
    }
}
