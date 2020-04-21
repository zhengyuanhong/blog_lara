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
        $path = $request->file('file')->store('avatars', 'public');
        return Response()->json(
            [
                'code' => 200,
                'msg' => '修改成功',
                'data' =>
                    [
                        'path' => User::saveAvatar($path),
                    ]
            ]);
    }
}
