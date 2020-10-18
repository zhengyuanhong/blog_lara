<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Installment
 * @package App\Models
 */
class Installment extends Model
{
    protected $table = 'installment';

    protected $fillable = [
     'user_id','price','name','pingtai','base'
    ];

    public function items(){
        return $this->hasMany(InstallmentItem::class,'install_id','id');
    }
}
