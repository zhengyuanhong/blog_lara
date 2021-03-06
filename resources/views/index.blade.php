@extends('layout.layout')

@section('content')
    <div class="layui-container" style="margin-top: 20px;">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8">
                <div class="fly-panel" style="margin-bottom: 0;">

                    <div class="fly-panel-title fly-filter">
                        青年时种下什么,老年时就收获什么
                    </div>
                    @if($article->count()>0)
                    @foreach($article as $a)
                        <ul class="fly-list">
                            <li>
                                <a href="{{route('user.detail',['user'=>$a->author->id])}}" class="fly-avatar">
                                    <img src="{{$a->author->avatar}}"
                                         alt="{{$a->author->name}}">
                                </a>
                                <h2>
                                    @if(isset($a->weight)&& $a->weight > 0)
                                    <a class="layui-badge">置顶</a>
                                    @endif
                                    <a href="{{route('article.detail',['article'=>$a->id])}}">{{$a->title}}</a>
                                </h2>
                                <div class="fly-list-info">
                                    <a href="{{route('user.detail',['user'=>$a->author->avatar])}}" link>
                                        <cite>{{$a->author->name}}</cite>
                                        {{--<!----}}
                                        {{--<i class="iconfont icon-renzheng" title="认证信息：XXX"></i>--}}
                                        {{--<i class="layui-badge fly-badge-vip">VIP3</i>--}}
                                        {{---->--}}
                                    </a>
                                    <span>{{app()->make('time_format')->timeFormat($a->created_at)}}</span>

                                    <span class="fly-list-nums">
                                    <i class="iconfont icon-pinglun1" title="回答"></i>{{$a->comments()->count()}}
                                </span>
                                </div>
                                <div class="fly-list-badge">
                                    {{--<!--<span class="layui-badge layui-bg-red">精帖</span>-->--}}
                                </div>
                            </li>
                        </ul>
                    @endforeach
                        @else
                        <div style="padding: 10px 0;color: grey;text-align: center;">暂无内容</div>
                    @endif
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

                <div class="fly-panel fly-link">
                    <h3 class="fly-panel-title">文章分类</h3>
                    <dl class="fly-panel-main">
                        @if(!empty($category))
                            @foreach($category as $v)
                                <dd><a href="/?category={{$v['id']}}" >{{$v['name']}}</a>
                                <dd>
                            @endforeach
                        @else
                            <dd>暂无<dd>
                        @endif
                    </dl>
                </div>

                <div class="fly-panel fly-link">
                    <h3 class="fly-panel-title">友情链接</h3>
                    <dl class="fly-panel-main">
                        @if(!empty($fineLink))
                            @foreach($fineLink as $v)
                        <dd><a href="{{$v['link']}}" target="_blank">{{$v['name']}}</a>
                        <dd>
                            @endforeach
                            @else
                            <dd>暂无<dd>
                            @endif
                    </dl>
                </div>

            </div>
        </div>
    </div>
@endsection

