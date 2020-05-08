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
        /** @var Wallet $wallet */
        $wallet = $event->user()->wallet;
        /** @var Order  $event */
        $wallet->income = (float)$wallet->income + (float)$event->price;
        $wallet->balance_fee = (float)$wallet->balance_fee + (float)$event->price ;
        $wallet->save();
        Log::info('钱包充值成功');

        /** @var WalletLog $walletLog */
        $walletLog = new WalletLog();
        $walletLog->user_id = $event->user_id;
        $walletLog->trade_no = $event->trade_no;
        $walletLog->type = $event->type;
        $walletLog->fee = $event->price;
        $walletLog->status = $event->pay_status=='success'?1:0;
        $walletLog->save();
        Log::info('钱包充值日志');
    }
}
