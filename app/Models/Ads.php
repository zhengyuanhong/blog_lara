<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $table='ads';

    public function scopeGetAd($query,$param){
        return $query->where('is_show',1)->where('type',$param);
    }
}
