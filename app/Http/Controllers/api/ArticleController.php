<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function articleApi(Request $request){
        $res = User::ownArticle();
        $data = [
            'code'=>200,
            'msg'=>'success',
            'data'=>$res,
        ];
        return Response()->json($data);
    }

    public function favoriteArticleApi(Request $request){
        $res = User::favoriteArticles();
        $data = [
            'code'=>200,
            'msg'=>'success',
            'data'=>$res,
        ];
        return Response()->json($data);
    }
}
