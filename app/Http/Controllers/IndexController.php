<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categories;
use App\Models\FineLink;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $article = Article::query()
            ->category($request->get('category'))
            ->where('articles.is_show','=',1)
            ->select('articles.*','users.name as username','users.avatar as user_avatar','users.rich as user_rich','categories.name as category_name')
            ->join('users','articles.user_id','=','users.id')
            ->join('categories','articles.category_id','=','categories.id')
            ->orderBy('weight','desc')
            ->orderBy('created_at','desc')
        ->paginate(20);
        $category = Categories::all();
        $fineLink = FineLink::all();
        return view('index',compact('article','fineLink','category'));
    }
}
