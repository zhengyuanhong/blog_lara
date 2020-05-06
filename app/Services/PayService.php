<?php
namespace App\Services;

use App\Utils\Wx\WxPayment;
use function foo\func;
use Illuminate\Support\Facades\Log;

class PayService{
    public $wx_pay;
    public function __construct(WxPayment $wx_pay)
    {
        $this->wx_pay = $wx_pay;
    }

    public function pay($pay_param){
       return $this->wx_pay->pay($pay_param);
    }

    public function notify($data){
        return $this->wx_pay->notify($data,function($result){

            $trade_order_id =$result['trade_order_id'];

            if($result['status']=='OD'){
                /************商户业务处理******************/
                //TODO:此处处理订单业务逻辑,支付平台会多次调用本接口(防止网络异常导致回调失败等情况)
                //     请避免订单被二次更新而导致业务异常！！！
                //     if(订单未处理){
                //         处理订单....
                //      }
                Log::info('success OD 回调函数::'.$trade_order_id);
                //....
                //...
                /*************商户业务处理 END*****************/
            }else{
                //处理未支付的情况
                Log::info('un success OD 回调函数::'.$trade_order_id);
            }
        });
    }
}
