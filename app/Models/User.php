<?php

namespace App\Models;

use App\Services\PayService;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


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
        'name', 'email', 'password', 'sign', 'sex', 'avatar'
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

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function weBoAccount()
    {
        return $this->hasOne(ThirdAccount::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
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

    public static function userWallet($user_id)
    {
        $wallet = Wallet::query()->firstOrCreate(['user_id' => $user_id]);
        app(PayService::class)->updateSign($wallet->toArray());
        return $wallet;
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
        if ($res) return $res;
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
        if ($res) return $res;
        Auth::user()->update(['password' => Hash::make($data['password'])]);
        return 'update';
    }

    public static function createUser($type, $data)
    {
        $user = new self;
        switch ($type) {
            case 'reg':
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = Hash::make($data['password']);
                break;
            case 'webo':
                $user->name = $data['name'];
                $user->email = date('His').'@songyu.com';
                $user->avatar = $data['avatar_large'];
                $user->sex = $data['gender'] == 'm' ? 1 : 0;
                $user->password = Hash::make(md5(random_int(10000000,999999999)));
                break;
        }
        $user->rich = 10;
        $user->save();

        Log::info('登录1:'.__LINE__);
        Auth::loginUsingId($user->id);
        Log::info('登录2:'.__LINE__);

        return $user;
    }

    public static function register($type, $data)
    {
        $user = self::createUser($type, $data);
        //注册时创建钱包
        self::userWallet($user->id);
        //绑定微博账号
        if($type=='webo'){
            self::bindWebo($data['id'], $user);
        }
    }

    public static function bindWebo($webo_uid, $user)
    {
        if (isset($webo_uid)) {
            if ($third_account = ThirdAccount::query()->where('webo_uid', $webo_uid)->first()) {
                $third_account->user_id = $user->id;
                $third_account->save();
            } else {
                ThirdAccount::create(['webo_uid' => $webo_uid, 'user_id' => $user->id]);
            }
        }
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
        return $articles->map(function ($v) {
            $temp = [];
            $temp['id'] = $v->id;
            $temp['title'] = $v->title;
            $temp['comment_num'] = $v->comments()->count();
            $temp['created_at'] = app()->make('time_format')->timeFormat($v->created_at);
            return $temp;
        });
    }

    public static function favoriteArticles()
    {
        $favorite_articles = User::query()->find(Auth::id())->collectArt()->orderBy('favorite.created_at', 'desc')->paginate(20);
        return $favorite_articles->map(function ($v) {
            $temp = [];
            $temp['id'] = $v->id;
            $temp['title'] = $v->title;
            $temp['created_at'] = app()->make('time_format')->timeFormat($v->pivot->created_at);
            return $temp;
        });
    }

    public static function saveAvatar($path)
    {
        Auth::user()->update(['avatar' => $path]);
        return $path;
    }
}
