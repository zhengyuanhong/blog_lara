<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Ads;
use App\Models\Article;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function detail(Request $request,Article $article){
        $comments = $article->comments()
            ->where('is_show',1)
            ->get();
        $resentArticle = Article::query()
            ->where('user_id',$article->user_id)
            ->resentArticle()
            ->limit(10)
            ->get();
        //推荐
        $adForOfficial = Ads::query()->getAd('official')->get()->toArray();
        //赞助商
        $adForSponsor = Ads::query()->getAd('sponsor')->get()->toArray();
        return view('article.detail',compact('article','comments','resentArticle','adForOfficial','adForSponsor'));
    }

    public function write(){
        /** @var Categories $category */
        $category = Categories::all();
        return view('article.write',compact('category'));
    }

    public function add(ArticleRequest $request){
        $request->validated();
        $data = $request->except('_token');
        Article::createArticle($data);
        return view('tip.message')->with('msg','发布成功');
    }

    public function editShow(Request $request,Article $article){
        $this->authorize('update',$article);
        return view('article.edit',compact('article'));
    }

    public function updateArticle(ArticleRequest $request){
        $articleId = $request->get('id');
        $request->validated('update',Article::query()->find($articleId));
        $data = $request->except('_token','file','id');
        Article::query()->find($articleId)->update($data);
        return view('tip.message')->with('msg','更新成功');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function favoriteArticle(Request $request){
        $user = User::query()->find(Auth::id());
        //1为收藏 0为取消收藏
        $status = $user->collection(intval($request->get('article_id')))?'取消收藏':'添加收藏';
        return Response()->json(['code'=>200,'msg'=>'操作成功','collect_status'=>$status]);
    }
}
