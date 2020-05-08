<?php

namespace App\Listeners;

use App\Models\Order;
use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ChangerWallet
{
    /**
     * Handle the event.
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        /** @var Order $order */
        $order = $event->getOrder();
        $wallet = Wallet::query()->where('user_id',$order->user_id)->first();
        $wallet->income = (float)$wallet->income + (float)$order->price;
        $wallet->balance_fee = (float)$wallet->balance_fee + (float)$order->price ;
        $wallet->save();
        Log::info('钱包充值成功');

        /** @var WalletLog $walletLog */
        $walletLog = new WalletLog();
        $walletLog->user_id = $order->user_id;
        $walletLog->trade_no = $order->trade_no;
        $walletLog->type = $order->type;
        $walletLog->fee = $order->price;
        $walletLog->status = $order->pay_status=='success'?1:0;
        $walletLog->save();
        Log::info('钱包充值日志');
    }
}
