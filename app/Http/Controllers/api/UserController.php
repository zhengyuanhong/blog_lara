<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Utils\Ucloud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $data = app()->make('util')->upload($request, 'avatars');
        if ($data['code'] == 201) {
            return Response()->json($data);
        }
        Log::info('path:' . storage_path('app/public/' . $data['data']['src']));
        $src = (new  Ucloud($data['key'], $data['data']['src']))->getKey($data['key']);
        User::saveAvatar($src);
        $data['data']['src'] = $src;
        return Response()->json($data);
    }
}
