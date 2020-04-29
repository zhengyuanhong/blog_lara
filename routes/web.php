<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;

//首页
Route::get('/', 'IndexController@index');
//文章
Route::get('/write', 'ArticleController@write')->name('article.write')->middleware('checkAuth');
Route::post('/article-add', 'ArticleController@add')->name('article.add')->middleware('checkAuth');
Route::get('/detail/{article}', 'ArticleController@detail')->name('article.detail');
Route::get('/detail/edit/{article}', 'ArticleController@editShow')->name('article.detail.edit.show')->middleware('checkAuth');
Route::post('/detail/edit', 'ArticleController@updateArticle')->name('article.detail.edit')->middleware('checkAuth');
Route::get('/collect-article', 'ArticleController@favoriteArticle')->middleware('checkAuth');
//评论
Route::post('/article/reply', 'CommentController@reply')->middleware('checkAuth');

//支付
Route::get('/pay','WechatPaymentController@pay')->middleware('checkAuth');
Route::get('/notify','WechatPaymentController@notify');


Route::namespace('api')->group(function () {
    Route::get('/own-article', 'ArticleController@articleApi')->middleware('checkAuth');
    Route::get('/favorite-article', 'ArticleController@favoriteArticleApi')->middleware('checkAuth');
    Route::get('/delete-message','UserController@delMsg')->middleware('checkAuth');
    Route::post('/set-info','UserController@setInfo')->middleware('checkAuth');
    Route::post('/set-pass','UserController@setPassword')->middleware('checkAuth');
    Route::post('/upload-avatar','UserController@uploadAvatar')->middleware('checkAuth');
    //上传图片
    Route::post('/upload-image','ArticleController@upload')->middleware('checkAuth');
});

//个人信息
Route::prefix('users')->namespace('User')->group(function () {
    Route::get('home', 'UserInfoController@home')->middleware('checkAuth')->name('user.home');
    Route::get('set', 'UserInfoController@set')->middleware('checkAuth')->name('user.set');
    Route::get('message', 'UserInfoController@message')->middleware('checkAuth')->name('user.message');
    Route::get('/{user}', 'UserInfoController@userInfo')->name('user.detail');
    Route::get('/u/recharge', 'UserInfoController@rechargePage')->middleware('checkAuth')->name('user.recharge');
});



//登陆、注册、退出
Route::namespace('User')->group(function () {
    Route::get('/login', 'UserController@goToLogin')->name('login');
    Route::post('/login', 'UserController@login')->name('user.post.login');
    Route::get('/reg', 'UserController@goToReg');
    Route::post('/reg', 'UserController@reg');
    Route::get('/logout', 'UserController@logout');
});



