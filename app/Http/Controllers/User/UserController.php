<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function goToLogin(){
        return view('users.login');
    }

    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $validator =  Validator::make($request->all(),[
            'password'=>'required',
            'email' =>'required'
        ]);

        if($validator->fails()){
            return redirect('/login')
                ->withErrors($validator);
        }

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('/login')->with('msg','账号或密码错误');
        }

        return redirect('/');
    }

    public function goToReg(){
        return view('users.reg');
    }

    public function reg(Request $request){
        $data = $request->all();
        $validator =  Validator::make($data,[
            'password'=>'required',
            'repassword'=>'required',
            'name' =>'required',
            'email' =>'required'
        ]);

        if($validator->fails()){
            return redirect('/reg')->with('msg','缺少信息');
        }

        //检查参数是否符合要求
        $res = User::checkParam($data);
        if($res){
            return redirect('/reg')->with('msg',$res);
        }

        //TODO 注册 发送邮箱

        /** @var User $user */
        User::register($data);
        return redirect('/login')->with('msg','注册成功');
    }

    public function  logout(){
        /** @var User $user */
        User::logout();
        return redirect('/');
    }
}
