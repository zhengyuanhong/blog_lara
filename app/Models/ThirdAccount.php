<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *@property  string id 自增ID
 *@property  string user_id 用户ID
 *@property  string webo_uid 微博uid
 *
 */
class ThirdAccount extends Model
{
    protected $table = 'third_account';

    protected $fillable = ['webo_uid','user_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
