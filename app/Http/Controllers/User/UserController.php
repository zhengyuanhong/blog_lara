<?php

namespace App\Http\Controllers\User;

use App\Models\ThirdAccount;
use App\Models\User;
use App\Utils\WeiBoLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function goToLogin(WeiBoLogin $webo)
    {
        $authorizeUrl = $webo->getAuthorizeURL();
        return view('users.login', compact('authorizeUrl'));
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator);
        }

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('/login')->with('msg', '账号或密码错误');
        }

        return redirect('/');
    }

    public function goToReg()
    {
        return view('users.reg');
    }

    public function reg(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'password' => 'required',
            'repassword' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/reg')->with('msg', '缺少信息');
        }

        //检查参数是否符合要求
        $res = User::checkParam($data);
        if ($res) {
            return redirect('/reg')->with('msg', $res);
        }

        //TODO 注册 发送邮箱

        /** @var User $user */
        User::register('reg', $data);

        return redirect('/');
    }

    public function logout()
    {
        /** @var User $user */
        User::logout();
        return redirect('/');
    }

    public function callback(request $request, WeiBoLogin $webo)
    {
        $code = $request->get('code');
        if(empty($code)) return redirect('/login')->with('msg','微博登录失败');

        $token = $webo->getAccessToken($code);
        $query = ThirdAccount::query();
        /** @var ThirdAccount $res */
        if ($res = $query->where('webo_uid', $token['uid'])->first()) {
            if($res->user_id){
                Auth::loginUsingId($res->user_id);
                Log::info('微博登录');
                return redirect('/');
            }
            return redirect('/login');
        }else{
            $weBoUserInfo = $webo->getWeBoUserInfo($token['access_token'], $token['uid']);
            User::register('webo', $weBoUserInfo);
            Log::info('微博注册登录');
            return redirect('/');
        }
    }
}
