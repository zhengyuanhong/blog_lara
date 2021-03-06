<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    public function home(){
        $type = 'info';
        $user =User::find(Auth::id());
        $article_num = $user->articles()->count();
        $favorite_num= $user->collectArt()->count();
        return view('users.info',compact('type','article_num','favorite_num'));
    }

    public function message(){
        $type = 'message';
        $user = Auth::user();
        if($user->unreadNotifications()->count()>0){
            $user->unreadNotifications->markAsRead();
        }
        return view('users.message',compact('type','user'));
    }

    public function set(){
        $type = 'set';
        $user = Auth::user();
        return view('users.set',compact('type','user'));
    }

    public function userInfo(User $user){
        $type = 'user';
        $comments = $user->comments()
            ->limit(20)
            ->orderBy('created_at','desc')
            ->get();
        $articles = $user->articles()
            ->where('is_show',1)
            ->limit(30)
            ->orderBy('created_at','desc')
            ->get();
        return view('users.user',compact('type','user','comments','articles'));
    }

    public function rechargePage(){
        $type = 'recharge';
        $userWallet = User::userWallet(Auth::id());
        return view('users.recharge',compact('type','userWallet'));
    }

    public function orderPage(){
        $type = 'order';
        /** @var User $userOrder */
        $query = User::query()->find(Auth::id())->order();
        $userOrder = $query->orderBy('created_at','desc')->paginate(10);
        //总额度
        $total =$query->whereNotNull('pay_at')->sum('price');
        return view('users.order',compact('type','userOrder','total'));
    }
}
