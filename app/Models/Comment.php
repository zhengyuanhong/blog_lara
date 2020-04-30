<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 *@property string id  唯一id
 *@property string user_id 发布者
 *@property string reply_user_id 回复者
 *@property string article_id 所属文章
 *@property string is_show 是否显示
 *@property string content 评论内容
 */
class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'user_id','reply_user_id','content','article_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function replyUser(){
        return $this->belongsTo(User::class,'reply_user_id','id');
    }

    public function article(){
        return $this->belongsTo(Article::class,'article_id','id');
    }

    public static function saveReply($data){
        $content = app()->make('util')->dealReply($data['content']);
        if(!$content['username']){
            $res = self::query()->create($data)->toArray();
            $res['user'] = Auth::user();
            return $res;
        }

        /** @var User $user */
        $user = User::query()->where('name',$content['username'])->first();
//            $user_link = '<a href="/users/{$user->id}">@'.$content["username"].' </a> ';

        //不能给自己回复
        if($data['user_id'] == $user->id){
            return false;
        }

        $user_link = sprintf('<a href="/users/%d">@%s </a>',$user->id,$user->name);
        //TODO 回复通知
        $data['reply_user_id'] = $user->id;
        $data['content'] = $user_link.$content['content'];
        $res = self::query()->create($data)->toArray();
        $res['user'] = Auth::user();
        return $res;
    }
}
