<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function reply(Request $request){
//        $this->authorize('update',Comment::class);
        $data = $request->except('_token');
        $res = Comment::saveReply($data);
        return Response()->json(['code'=>200,'msg'=>'发布成功','data'=>$res]);
    }
}
