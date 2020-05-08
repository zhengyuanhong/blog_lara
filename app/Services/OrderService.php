<?php
namespace App\Services;

use App\Models\Order;
use App\Models\User;

class OrderService{
    public function store(User $user,$money){
        $order = new Order();
        $order->price = $money;
        $order->pay_status = Order::PAY_STATUS_PROCESSING;
        $order->type = Order::ORDER_TYPE_RECHARGE;
        $order->user()->associate($user);
        $order->save();
        $pay_param = [
            'total_fee' =>$money,//人民币，单位精确到分(测试账户只支持0.1元内付款)
            'title' => Order::$orderTypeMap[Order::ORDER_TYPE_RECHARGE], //必须的，订单标题，长度32或以内
            'trade_order_id'=>$order->trade_no,
        ];

        return [$pay_param,$order];
    }
}
