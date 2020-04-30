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
        $this->wx_pay->notify($data);
        return 'success';
    }
}
