<?php

namespace App\Services;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\Wallet;
use App\Utils\Wx\WxPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PayService
{
    public $wx_pay;
    public $wallet_key;

    public function __construct(WxPayment $wx_pay)
    {
        $this->wx_pay = $wx_pay;
        $this->wallet_key = 'key';
    }

    public function pay($pay_param)
    {
        return $this->wx_pay->pay($pay_param);
    }

    public function notify($data)
    {
        return $this->wx_pay->notify($data, function ($result) {

            $trade_order_id = $result['trade_order_id'];

            if ($result['status'] == 'OD') {
                /************商户业务处理******************/
                Log::info('success OD 回调函数::' . $trade_order_id);
                /** @var Order $order */
                $order = Order::query()->where('trade_no',$trade_order_id)->first();
                //如果订单已经处理
                if(in_array($order->pay_status,[Order::PAY_STATUS_SUCCESS,Order::PAY_STATUS_FAILED])){
                    Log::info('订单已经处理::trade_no' . $trade_order_id);
                    return true;
                }
                //如果已经支付
                if($order->pay_at){
                    Log::info('已经支付成功::trade_no' . $trade_order_id);
                   return true;
                }
                //否则处理订单
                $order->update([
                    'pay_at'=>Carbon::now(),
                    'pay_status'=>Order::PAY_STATUS_SUCCESS
                ]);
                Log::info('支付成功::trade_no' . $trade_order_id);
                return $order;
            } else {
                Log::info('un success OD 回调函数::' . $trade_order_id);
            }
        });
    }

    public function removeKey($wallet)
    {
        unset($wallet['created_at']);
        unset($wallet['updated_at']);
        unset($wallet['check_sign']);
        return $wallet;
    }

    public function updateSign($wallet)
    {
        $wallet = $this->removeKey($wallet);
        $sign =  $this->encode_HMAC($wallet);
        /** @var Wallet $updateWallet */
        $updateWallet = Wallet::query()->find($wallet['id']);
        $updateWallet->check_sign = $sign;
        $updateWallet->save();
    }

    public function walletCheckSign($wallet)
    {
        $checkSignDb = $wallet['check_sign'];
        $check = false;
        $wallet = $this->removeKey($wallet);

        $checkSign = $this->encode_HMAC($wallet);
        if ($checkSignDb == $checkSign) {
            $check = true;
        }
        return $check;
    }

    public function encode_HMAC($wallet)
    {
        if (empty($wallet) && !is_array($wallet)) {
            Log::info('wallet 为空!');
            return false;
        }
        ksort($wallet);
        $str = '';
        foreach ($wallet as $k => $v) {
            $str = $str . '&' . $k . '=' . $v;
        }
        $str = trim($str, '&');
        $str = $str . '&key=' . $this->wallet_key;
        Log::info('info HMAC:'.$str);
        $checkSign =  strtoupper(hash_hmac('sha256', $str, $this->wallet_key));
        Log::info('HMAC check_sign:'.$checkSign);
        return $checkSign;
    }
}
