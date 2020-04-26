<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Utils\Ucloud;
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
    public function upload(Request $request){
        $data = app()->make('util')->upload($request,'article');
        if($data['code']==201){
            return Response()->json($data);
        }
        $src = (new  Ucloud($data['key'], $data['data']['src']))->getKey($data['key']);
        $data['code'] = 0;
        $data['data']['src'] = $src;
        $data['data']['style'] = 'display:inline-block;height:auto;max-with:100%';
        return Response()->json($data);
    }
}
