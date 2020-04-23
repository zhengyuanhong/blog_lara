<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function delMsg()
    {
        Auth::user()->notifications()->delete();
        return Response()->json(['code' => 200, 'msg' => '已清空']);
    }

    public function setInfo(Request $request)
    {
        $data = $request->except('_token', 'email');
        $user = Auth::user();
        $user->update($data);
        return Response()->json(['code' => 200, 'msg' => '修改成功']);
    }

    public function setPassword(Request $request)
    {
        $data = $request->except('_token');
        $res = User::resetPassword($data);
        if ($res != 'update') {
            return Response()->json(['code' => 201, 'msg' => $res]);
        }
        return Response()->json(['code' => 200, 'msg' => '修改成功']);
    }

    public function uploadAvatar(Request $request)
    {
        $file = $request->file('file');
        $data = [];
        //最大只能1M
        if($file->getSize()/1024 > 1024*1024){
            $data['code'] = 201;
            $data['msg'] = '图片不能大于1M';
            return Response()->json($data);
        }
        $path = $file->store('avatars', 'public');
        $data['code'] = 200;
        $data['msg'] = '上传成功';
        $data['data']['path'] = User::saveAvatar($path);
        return Response()->json($data);
    }
}
