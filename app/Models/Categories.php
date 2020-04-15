<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *@property string id ID
 *@property string name 书籍名称
 *@property string is_show 是否显示
 */
class Categories extends Model
{
    protected $table = 'categories';

    public function article(){
        return $this->hasMany(Article::class,'category_id','id');
    }
}
