@extends('layout.layout')

@section('content')
    <div class="layui-container" style="margin-top: 20px;">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8">
                <div class="fly-panel" style="margin-bottom: 0;">

                    <div class="fly-panel-title fly-filter">
                       呵呵呵呵...
                    </div>
                    @foreach($article as $a)
                        <ul class="fly-list">
                            <li>
                                <a href="{{route('user.detail',['user'=>$a->user_id])}}" class="fly-avatar">
                                    <img src="{{$a->user_avatar}}"
                                         alt="{{$a->user_name}}">
                                </a>
                                <h2>
                                    @if(isset($a->weight)&& $a->weight > 0)
                                    <a class="layui-badge">置顶</a>
                                    @endif
                                    <a href="{{route('article.detail',['article'=>$a->id])}}">{{$a->title}}</a>
                                </h2>
                                <div class="fly-list-info">
                                    <a href="{{route('user.detail',['user'=>$a->user_id])}}" link>
                                        <cite>{{$a->username}}</cite>
                                        <!--
                                        <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                                        <i class="layui-badge fly-badge-vip">VIP3</i>
                                        -->
                                    </a>
                                    <span>{{app()->make('time_format')->timeFormat($a->created_at)}}</span>

                                    <span class="fly-list-kiss layui-hide-xs" title="财富">财富：{{$a->user_rich}}</span>
                                    <span class="fly-list-nums">
                                    <i class="iconfont icon-pinglun1" title="回答"></i>{{$a->comments()->count()}}
                                </span>
                                </div>
                                <div class="fly-list-badge">
                                    <!--<span class="layui-badge layui-bg-red">精帖</span>-->
                                </div>
                            </li>
                        </ul>
                    @endforeach
                    <div style="text-align: center;padding-bottom: 10px;">
                        @if($article->currentPage() == $article->onFirstPage())
                        @else
                            <a href="{{$article->previousPageUrl()}}">上一页</a>
                        @endif

                        @if($article->currentPage() == $article->lastPage())
                        @else
                            <a href="{{$article->nextPageUrl()}}">下一页</a>
                        @endif
                    </div>

                </div>
            </div>
            <div class="layui-col-md4">

                <div class="fly-panel">
                    <div class="fly-panel-title">
                        发布文章
                    </div>
                    <div class="fly-panel-main fly-signin-main">
                        <a href="{{url('/write')}}" class="layui-btn layui-btn-primary">发布文章</a>
                    </div>
                </div>

                <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
                    <h3 class="fly-panel-title">回贴周榜</h3>
                    <dl>
                        <!--<i class="layui-icon fly-loading">&#xe63d;</i>-->
                        <dd>
                            <a href="users/home.html">
                                <img src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg"><cite>贤心</cite><i>106次回答</i>
                            </a>
                        </dd>
                    </dl>
                </div>

                <div class="fly-panel fly-link">
                    <h3 class="fly-panel-title">友情链接</h3>
                    <dl class="fly-panel-main">
                        <dd><a href="http://www.layui.com/" target="_blank">layui</a>
                        <dd>
                    </dl>
                </div>

            </div>
        </div>
    </div>
@endsection

