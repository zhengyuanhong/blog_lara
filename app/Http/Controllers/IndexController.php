<?php

namespace App\Http\Controllers;

use App\Jobs\RepaymentNotify;
use App\Models\Article;
use App\Models\Categories;
use App\Models\FineLink;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
//        $article = Article::query()
//            ->category($request->get('category'))
//            ->where('articles.is_show', '=', 1)
//            ->select('articles.*', 'users.name as username', 'users.avatar as user_avatar', 'users.rich as user_rich', 'categories.name as category_name')
//            ->join('users', 'articles.user_id', '=', 'users.id')
//            ->join('categories', 'articles.category_id', '=', 'categories.id')
//            ->orderBy('weight', 'desc')
//            ->orderBy('created_at', 'desc')
//            ->paginate(20);
        $query = Article::query()->with(['author', 'category']);

        if ($category = $request->get('category')) {
            $query = $query->where('category_id', $request->get('category'));
        }

        $article = $query->where('is_show', 1)
            ->orderBy('weight', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        $category = Categories::query()->where('is_show', 1)->get()->toArray();
        $fineLink = FineLink::all()->toArray();
        return view('index', compact('article', 'fineLink', 'category'));
    }
}
