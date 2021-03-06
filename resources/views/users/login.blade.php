@extends('layout.layout')

@section('content')
<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li class="layui-this">登入</li>
        <li><a href="{{url('/reg' )}}">注册</a></li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">
            <form method="post" action="{{route('user.post.login')}}">
              @csrf
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_email" name="email" required lay-verify="required" autocomplete="on" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>

                <div class="layui-form-mid">
                  @if(!empty(session('msg')))
                    <span style="color: darkgreen;">{{session('msg')}}</span>
                  @endif
                </div>
              </div>
              <div class="layui-form-item">
                <button class="layui-btn" lay-filter="login" lay-submit>立即登录</button>
                <a class="layui-btn layui-btn-normal" href="{{$authorizeUrl}}">微博登录</a>
                <span style="padding-left:20px;">
                  {{--<a href="forget.html">忘记密码？</a>--}}
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection