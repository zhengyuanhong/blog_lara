<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *@property  string id
 *@property  string trade_no 订单号
 *@property  string user_id 用户id
 *@property  string type 类型
 *@property  string fee 金额
 *@property  string status 1：已完成 0：未完成
 *@property  string created_at 创建时间
 */
class WalletLog extends Model
{
    protected $table = 'wallet_log';
}
