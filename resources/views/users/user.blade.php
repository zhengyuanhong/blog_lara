@extends('layout.layout')

@section('content')
    <div class="fly-home fly-panel" style="background-image: url();">
        <img src="{{$user->avatar}}" alt="{{$user->name}}">
        <i class="iconfont icon-renzheng" title="Fly社区认证"></i>
        <h1>
            {{$user->name}}
            <i class="iconfont {{$user->sex==1?'icon-nan':'icon-nv'}}"></i>
            <!-- <i class="iconfont icon-nv"></i>  -->
            <!--
            <span style="color:#c00;">（管理员）</span>
            <span style="color:#5FB878;">（社区之光）</span>
            <span>（该号已被封）</span>
            -->
        </h1>

        <p class="fly-home-info">
            <span style="color: #FF7200;">财富 {{$user->rich}}</span>
            <i class="iconfont icon-shijian"></i><span>{{$user->created_at}} 加入</span>
        </p>

        <p class="fly-home-sign">{{$user->sign??'（人生仿若一场修行）'}}</p>

        @auth
            @if($user->id == Request()->user()->id)
        <div class="fly-sns" data-user="">
            <a href="{{route('article.write')}}" class="layui-btn layui-btn-primary fly-imActive" data-type="addFriend">写文章</a>
        </div>
                @endif
            @endauth

    </div>

    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md6 fly-home-jie">
                <div class="fly-panel">
                    <h3 class="fly-panel-title">{{$user->name}} 最近写的文章</h3>
                    <ul class="jie-row">
                        @if(empty($articles))
                            <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i
                                        style="font-size:14px;">没有发表任何文章</i></div>
                        @else
                            @foreach($articles as $v)
                                <li>
                                    <a href="{{route('article.detail',['article'=>$v->id])}}" class="jie-title"> {{$v->title}}</a>
                                    <i>{{app()->make('time_format')->timeFormat($v->created_at)}}</i>
                                    <em class="layui-hide-xs">{{$v->comments()->count()}}评论</em>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="layui-col-md6 fly-home-da">
                <div class="fly-panel">
                    <h3 class="fly-panel-title">{{$user->name}} 最近参与评论</h3>
                    <ul class="home-jieda">
                        @if(empty($comments))
                            <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;">
                                <span>没有任何评论</span></div>
                        @else
                            @foreach($comments as $v)
                                <li>
                                    <p>
                                        <span>{{app()->make('time_format')->timeFormat($v->created_at)}}</span>
                                        在<a href="{{route('article.detail',['article'=>$v->article->id])}}"
                                            target="_blank">{{$v->article->title}}</a>中评论：
                                    </p>
                                    <div class="home-dacontent">
                                        {!! $v->content !!}
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

