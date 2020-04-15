@extends('layout.layout')

@section('content')
    <div class="layui-container" style="margin-top: 20px;">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8 content detail">
                <div class="fly-panel detail-box">
                    <h1>{{$article->title}}</h1>
                    <div class="fly-detail-info">
                        <!-- <span class="layui-badge">审核中</span> -->
                        <span class="layui-badge layui-bg-green fly-detail-column">动态</span>

                        <span class="layui-badge" style="background-color: #999;">未结</span>
                        <!-- <span class="layui-badge" style="background-color: #5FB878;">已结</span> -->

                        <span class="layui-badge layui-bg-black">置顶</span>
                        <span class="layui-badge layui-bg-red">精帖</span>

                        <div class="fly-admin-box" data-id="123">
                            <span class="layui-btn layui-btn-xs jie-admin" type="del">删除</span>

                            <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="1">置顶</span>
                            <!-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="0" style="background-color:#ccc;">取消置顶</span> -->

                            <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="1">加精</span>
                            <!-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="0" style="background-color:#ccc;">取消加精</span> -->
                        </div>
                        <span class="fly-list-nums">
            <a href="#comment"><i class="iconfont" title="回答">&#xe60c;</i>{{$article->comments()->count()}}</a>
          </span>
                    </div>
                    <div class="detail-about">
                        <a class="fly-avatar" href="{{route('user.detail',['user'=>$article->user_id])}}">
                            <img src="{{$article->author->avatar}}" alt="{{$article->author->name}}">
                        </a>
                        <div class="fly-detail-user">
                            <a href="{{route('user.detail',['user'=>$article->user_id])}}" class="fly-link">
                                <cite>{{$article->author->name}}</cite>
                                <i class="iconfont icon-renzheng" title="认证信息：dd"></i>
                            </a>
                            <span>{{app()->make('time_format')->timeFormat($article->created_at)}}</span>
                        </div>
                        <div class="detail-hits" id="LAY_jieAdmin" data-id="{{$article->id}}">
                            <span style="padding-right: 10px; color: #FF7200">财富：{{$article->author->rich}}</span>
                            @auth
                                @if($article->user_id != Request()->user()->id)
                                <span class="layui-btn layui-btn-xs layui-btn-warm" type="edit"><a data-article="{{$article->id}}" id="collect">{{$article->author->isCollect($article->id)?'取消收藏':'收藏此贴'}}</a></span>
                                @endif
                                @if($article->user_id == Request()->user()->id)
                                    <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a
                                                href="{{route('article.detail.edit.show',['article'=>$article->id])}}">编辑此贴</a></span>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="detail-body photos">
                        {!! $article->content !!}
                    </div>
                </div>

                <div class="fly-panel detail-box" id="flyReply">
                    <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
                        <legend>评论</legend>
                    </fieldset>

                    <ul class="jieda" id="jieda">
                        @if(empty($comments))
                            <li class="fly-none">消灭零回复</li>
                        @else
                            @foreach($comments as $k=>$v)
                                <li data-id="{{$k}}" class="jieda-daan">
                                    <a name="item-{{$k}}"></a>
                                    <div class="detail-about detail-about-reply">
                                        <a class="fly-avatar" href="">
                                            <img src="{{$v->user->avatar}}"
                                                 alt=" ">
                                        </a>
                                        <div class="fly-detail-user">
                                            <a href="{{route('user.detail',['user'=>$v->user->id])}}" class="fly-link">
                                                <cite>{{$v->user->name}}</cite>
                                            </a>
                                            @if($article->user_id == $v->user->id)
                                                <span>(楼主)</span>
                                        @endif
                                        <!--
                                            <span style="color:#5FB878">(管理员)</span>
                                            <span style="color:#FF9E3F">（社区之光）</span>
                                            <span style="color:#999">（该号已被封）</span>
                                            -->
                                        </div>

                                        <div class="detail-hits">
                                            <span>{{app()->make('time_format')->timeFormat($v->created_at)}}</span>
                                        </div>
                                    </div>
                                    <div class="detail-body jieda-body photos">
                                        <p>{!! $v->content !!}</p>
                                    </div>
                                    <div id="reply_user" class="jieda-reply">

                                           <span class="reply_btn" data-username='{{$v->user->name}}'
                                                 id='{{$v->user->id}}' type="reply">
                <i class="iconfont icon-svgmoban53"></i>
                回复
              </span>

                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    @auth
                        <div class="layui-form layui-form-pane">
                            <form action="" method="post">
                                <div class="layui-form-item layui-form-text">
                                    <a name="comment"></a>
                                    <div class="layui-input-block">
                <textarea id="L_content" name="content" lay-verify="required" placeholder="请输入内容" class="layui-textarea"
                          style="height: 150px;"></textarea>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <input type="hidden" name="user_id" value="{{request()->user()->id}}">
                                    <input type="hidden" name="article_id" value="{{$article->id}}">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <button class="layui-btn" lay-filter="reply" lay-submit>提交回复</button>
                                </div>
                            </form>
                        </div>
                    @endauth
                    @guest
                        <div style="margin: 0 auto;text-align: center;padding: 40px 0;border: 1px solid gray;"><a
                                    href="{{url('login')}}"
                                    class="layui-btn layui-btn-primary">登陆可评论</a></div>
                    @endguest
                </div>
            </div>
            <div class="layui-col-md4">
                <dl class="fly-panel fly-list-one">
                    <dt class="fly-panel-title">ta最近写的文章</dt>
                    @if(!empty($resentArticle))
                        @foreach($resentArticle as $v)
                            <dd>
                                <a href="{{route('article.detail',['article'=>$v->id])}}">{{$v->title}}</a>
                                <span><i class="iconfont icon-pinglun1"></i>{{$v->comments()->count()}}</span>
                            </dd>
                        @endforeach
                    @else
                        <div class="fly-none">没有相关数据</div>
                    @endif
                </dl>

                <div class="fly-panel">
                    <div class="fly-panel-title">
                        这里可作为广告区域
                    </div>
                    <div class="fly-panel-main">
                        <a href="http://layim.layui.com/?from=fly" target="_blank" class="fly-zanzhu"
                           time-limit="2017.09.25-2099.01.01" style="background-color: #5FB878;">LayIM 3.0 - layui
                            旗舰之作</a>
                    </div>
                </div>

                <div class="fly-panel" style="padding: 20px 0; text-align: center;">
                    <img src="../../res/images/weixin.jpg" style="max-width: 100%;" alt="layui">
                    <p style="position: relative; color: #666;">微信扫码关注 layui 公众号</p>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['jquery', 'form'], function () {
            var $ = layui.jquery
            var form = layui.form
            //回复功能
            $('span.reply_btn').click(function () {
                console.log('ddd')
                var str = '@' + $(this).attr('data-username') + ' '
                $('#L_content').val(str)
                $("#L_content").focus();
            })

            form.on('submit(reply)', function (data) {
                $.ajax({
                    url: '/article/reply',
                    method: 'post',
                    data: data.field,
                    dataType: 'JSON',
                    success: function (res) {
                        $('#L_content').val('')
                        if (res.code == 200) {
                            console.log(res)
                            layer.msg((res.msg));
                            var value = res.data
                            var reply_content = `<li data-id="${value.user.id}" class="jieda-daan">
    <div class="detail-about detail-about-reply" >
      <a class="fly-avatar" href="/users/${value.user.id}">
        <img src="${value.user.avatar}" alt="${value.user.name}">
            </a>
        <div class="fly-detail-user">
          <a href="/users/${value.user.id}" class="fly-link">
            <cite>${ value.user.name}</cite>
          </a>
        </div>

        <div class="detail-hits">
          <span>${ value.created_at}</span>
        </div>

          </div>
      <div class="detail-body jieda-body photos">
        <p class="reply_content" data-id=${ value.id} >${value.content}</p>
      </div>
      <div class="jieda-reply">
        <span class="reply_btn" data-username='${value.user.name}' id='${value.user.id}' type="reply">
          <i class="iconfont icon-svgmoban53"></i>
              回复
        </span>
      </div>
     </li>`
                            $('#jieda').append(reply_content)
                        } else {
                            layer.msg(res.msg);
                        }
                    }
                });
                return false
            })

            var article_id = $('#collect').attr('data-article');

            $('#collect').click(function(){
                $.ajax({
                    url: '/collect-article',
                    method: 'get',
                    data: {
                        article_id:article_id
                    },
                    dataType: 'JSON',
                    success: function (res) {
                        if(res.code=200){
                            layer.msg(res.msg)
                            $('#collect').text(res.collect_status)
                        }else{
                            layer.msg('操作失败')
                        }
                    }
                })
            })
        });
    </script>
@endsection