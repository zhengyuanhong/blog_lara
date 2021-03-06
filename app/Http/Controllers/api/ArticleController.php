<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Utils\Ucloud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function articleApi(Request $request){
        $data = [
            'code'=>200,
            'msg'=>'success',
            'data'=>User::ownArticle()
        ];
        return Response()->json($data);
    }

    public function favoriteArticleApi(Request $request){
        $data = [
            'code'=>200,
            'msg'=>'success',
            'data'=>User::favoriteArticles(),
        ];
        return Response()->json($data);
    }
    public function upload(Request $request){
        $data = app()->make('util')->upload($request,'article');
        if($data['code']==201){
            return Response()->json($data);
        }
        $data['code'] = 0;
        $data['data']['src'] = (new  Ucloud($data['key'], $data['data']['src']))->getKey($data['key']);
        $data['data']['style'] = 'display:inline-block;height:auto;max-with:100%';
        return Response()->json($data);
    }
}
