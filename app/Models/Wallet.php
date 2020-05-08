<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *@property  string id 自增
 *@property  string  user_id 用户id
 *@property  string income 总收入
 *@property  string outcome 总支出
 *@property  string balance_fee 可用余额
 *@property  string check_sign 验证签名
 *@property  string created_at 创建时间
 */
class Wallet extends Model
{
    protected $table = 'wallet';

    protected $fillable = [
     'user_id','income','outcome','balance_fee','check_sign'
    ];
}
