<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * @property string id 唯一id
 * @property string user_id 发布者
 * @property string category_id 所属分类
 * @property string tag 标签
 * @property string title 标题
 * @property string content 内容
 * @property string is_show 是否显示
 * @property string is_top 是否置顶
 */
class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'user_id', 'category_id', 'title', 'content', 'is_show'
    ];

    public static function createArticle($data)
    {
        $data['user_id'] = Auth::id();
        $data['is_show'] = 1;
        self::create($data);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeResentArticle($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
