<?php

namespace App\Http\Controllers\User;

use App\Services\OrderService;
use App\Services\PayService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    public function recharge(Request $request,OrderService $orderService,PayService $payService){
        $money = $request->get('money',1);
        $user = $request->user();
        list($pay_param,$order) = $orderService->store($user,$money);
        //检查权限
        $this->authorize('own',$order);
        //支付
        $res = $payService->pay($pay_param);
        //检查钱包
        if(!$payService->walletCheckSign($user->wallet->toArray())){
            Log::info('账户异常'.__FILE__);
            return Response()->json(['code'=>201,'data'=>'账户异常']);
        }
        return Response()->json(['code'=>200,'data'=>$res['url']]);
    }
}
