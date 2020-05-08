<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Services\PayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WechatPaymentController extends Controller
{
    public $wx_pay;
    public function __construct(PayService $wx_pay)
    {
        $this->wx_pay = $wx_pay;
    }

    public function pay(Request $request)
    {
        //TODO
        $total_fee = $request->get('total_fee',0.01);
        $title = $request->get('title','test');
        $trade_order_id = $request->get('trade_order_id',time());

        $data = [
            'total_fee' =>$total_fee ,//人民币，单位精确到分(测试账户只支持0.1元内付款)
            'title' => $title, //必须的，订单标题，长度32或以内
            'trade_order_id'=>$trade_order_id,
        ];
        $res = $this->wx_pay->pay($data);
        dd($res);
//        return Response()->json($res);
    }

    public function notify(Request $request){
        $data = $request->all();
        $res =$this->wx_pay->notify($data);
        if($res!=true){
            Log::info('success 支付成功');
            $this->afterPid($res);
        }
        return 'success';
    }
    public function afterPid(Order $order){
        event(new OrderPaid($order));
    }
}
