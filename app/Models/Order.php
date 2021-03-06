<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

/**
 * @property string id 自增
 * @property string user_id 用户id
 * @property string trade_no 订单号
 * @property string price 价格
 * @property string type 订单类型
 * @property string created_at 创建时间
 * @property string updated_at 更新时间
 * @property string pay_status 支付状态
 * @property string pay_at 支付时间
 */
class Order extends Model
{
    protected $table = 'order';

    protected $fillable = ['user_id','trade_no','price','type','pay_status','pay_at','created_at','updated_at'];

    const PAY_STATUS_FAILED = 'failed'; //支付失败
    const PAY_STATUS_SUCCESS = 'success'; //支付成功
    const PAY_STATUS_PROCESSING = 'processing';//待支付

    public static $payStatusMap = [
        self::PAY_STATUS_FAILED =>'支付失败',
        self::PAY_STATUS_SUCCESS =>'支付成功',
        self::PAY_STATUS_PROCESSING =>'待支付',
    ];

    const ORDER_TYPE_RECHARGE = 'recharge'; //充值
    const ORDER_TYPE_BUY = 'buy'; //下单

    public static $orderTypeMap = [
        self::ORDER_TYPE_RECHARGE =>'钱包充值',
        self::ORDER_TYPE_BUY =>'购买服务'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function ($model){
            $model->trade_no = static::findAvailableNo();
            if(!$model->trade_no){
                return false;
            }
        });
    }

    public static function findAvailableNo(){
        $prefix = date('YmdHis');
        for($i=0;$i<10;$i++){
            $no = $prefix.str_pad(random_int(1,999999),6,'0',STR_PAD_LEFT);
            if(!static::query()->where('trade_no',$no)->exists()){
                return $no;
            }
        }
        return false;
    }
}
