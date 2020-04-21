<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


/**
 * @property string id 唯一id
 * @property string avatar 用户头像
 * @property string sex 性别 1男 0女
 * @property string last_login 用户登陆时间
 * @property string email 邮箱
 * @property string password 密码
 * @property string rich 财富
 * @property string name 用户名
 * @property string sign 签名
 */
class User extends Authenticatable
{
    use Notifiable {
        notify as laravelNotify;
    }
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'sign', 'sex','avatar'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function notify($instance)
    {
        if ($this->id == Auth::id()) {
            return;
        }
        $this->laravelNotify($instance);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->hasMany(Categories::class, 'user_id', 'id');
    }

    public static function exitName($name)
    {
        return self::query()->where('name', $name)->exists();
    }

    public static function exitEmail($email)
    {
        return self::query()->where('email', $email)->exists();
    }

    public static function checkParam($data)
    {

        if (self::exitEmail($data['email'])) {
            return '该邮箱已注册';
        }

        if (self::exitName($data['name'])) {
            return '该昵称已存在';
        }

        $res = self::checkPassword($data);
        if($res) return $res;
        return null;
    }

    public static function checkPassword($data)
    {
        if (strlen($data['password']) < 8) {
            return '密码太短，不得少于8位';
        }

        if ($data['repassword'] != $data['password']) {
            return '密码不一致';
        }
    }

    public static function resetPassword($data)
    {
        $res = self::checkPassword($data);
        if($res) return $res;
        if (Hash::check($data['nowpassword'], User::find(Auth::id())->password)) {
            Auth::user()->update(['password' => Hash::make($data['password'])]);
            return 'update';
        }
        return '原密码不正确';
    }

    public static function register($data)
    {
        $user = new self;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->rich = 10;
        $user->save();
    }

    public static function logout()
    {
        /** @var self $user */
        $user = self::query()->find(Auth::id());
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();
        Auth::logout();
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function collectArt()
    {
        return $this->belongsToMany('App\Models\Article', 'favorite', 'user_id', 'article_id')->withTimestamps();
    }

    public function isCollect($article_id)
    {
        return $this->collectArt()->wherePivot('article_id', $article_id)->exists();
    }

    public function collection($article_id)
    {
        $is_exists = $this->isCollect($article_id);
        if ($is_exists) {
            $this->collectArt()->detach($article_id);
            //取消收藏成功
            return false;
        }

        $this->collectArt()->attach($article_id);
        return true;
    }

    public static function ownArticle()
    {
        $articles = User::find(Auth::id())->articles()->orderBy('created_at', 'desc')->paginate(20);
        $data = [];
        foreach ($articles as $v) {
            $temp = [];
            $temp['id'] = $v->id;
            $temp['title'] = $v->title;
            $temp['comment_num'] = $v->comments()->count();
            $temp['created_at'] = app()->make('time_format')->timeFormat($v->created_at);
            $data[] = $temp;
        }
        return $data;
    }

    public static function favoriteArticles()
    {
        $favorite_articles = User::query()->find(Auth::id())->collectArt()->orderBy('favorite.created_at', 'desc')->paginate(20);
        $data = [];
        foreach ($favorite_articles as $v) {
            $temp = [];
            $temp['id'] = $v->id;
            $temp['title'] = $v->title;
            $temp['created_at'] = app()->make('time_format')->timeFormat($v->pivot->created_at);
            $data[] = $temp;
        }
        return $data;
    }

    public static function saveAvatar($path){
        $url = env('APP_URL').'/storage/'.$path;
        Auth::user()->update(['avatar'=>$url]);
        return $url;
    }
}
