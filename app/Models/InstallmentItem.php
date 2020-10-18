<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentItem extends Model
{
    protected $table = 'install_items';
    protected $dates = ['repay_date'];
    protected $fillable = ['sequence','fee','repay_date','status'];
    public $timestamps = false;

    public function installment(){
        return $this->belongsTo(Installment::class,'install_id','id');
    }
}
