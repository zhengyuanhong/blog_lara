@extends('layout.layout')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('common.user-info-nav',['type'=>$type])
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
                <button class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</button>
                <div id="LAY_minemsg" style="margin-top: 10px;">
                    @if($user->notifications->count() > 0)
                        <ul class="mine-msg">
                            @foreach($user->notifications as $k=>$notification)
                                <li data-id="{{$k}}">
                                    @if($notification->data['reply_user_id'] == 'empty')
                                        <blockquote class="layui-elem-quote">
                                            <a href="{{route('user.detail',['user'=>$notification->data['user_id']])}}"
                                               target="_blank"><cite>{{$notification->data['username']}}</cite></a>评论了你的文章<a
                                                    target="_blank"
                                                    href="{{$notification->data['link']}}"><cite>{{$notification->data['article_title']}}</cite></a>
                                        </blockquote>
                                    @else
                                        <blockquote class="layui-elem-quote">
                                            <a href="{{route('user.detail',['user'=>$notification->data['user_id']])}}"
                                               target="_blank">
                                                <cite>{{$notification->data['username']}}</cite>
                                            </a>在文章<a target="_blank"
                                                      href="{{$notification->data['link']}}"><cite>{{$notification->data['article_title']}}</cite></a>
                                            回复了你
                                        </blockquote>
                                    @endif
                                    <p>
                                        <span>{{app()->make('time_format')->timeFormat($notification->data['time'])}}</span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="fly-none">您暂时没有最新消息</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['jquery', 'element'], function () {
            var $ = layui.jquery

            $('#LAY_delallmsg').click(function () {
                $.ajax({
                    url: '/delete-message',
                    method: 'get',
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.code = 200) {
                            layer.msg(res.msg)
                            $('#LAY_minemsg').html('<div class="fly-none">您暂时没有最新消息</div>')
                        }
                    }
                })
            })
        })
    </script>
@endsection

