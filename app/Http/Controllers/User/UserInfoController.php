<?php

namespace App\Http\Controllers\User;

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
        $user = User::query()->find(Auth::id());
        return view('users.message',compact('type','user'));
    }

    public function set(){
        $type = 'set';
        return view('users.set',compact('type'));
    }

    public function userInfo(User $user){
        $type = 'user';
        $comments = $user->comments()
            ->limit(20)
            ->orderBy('created_at','desc')
            ->get();
        $articles = $user->articles()
            ->limit(30)
            ->orderBy('created_at','desc')
            ->get();
        return view('users.user',compact('type','user','comments','articles'));
    }
}
