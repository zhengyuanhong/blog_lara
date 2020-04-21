@extends('layout.layout')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('common.user-info-nav',['type'=>$type])
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <li class="layui-this" lay-id="info">我的资料</li>
                    <li lay-id="avatar">头像</li>
                    <li lay-id="pass">密码</li>
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-form layui-form-pane layui-tab-item layui-show">
                        <form method="post" action="">
                            <div class="layui-form-item">
                                <label for="L_email" class="layui-form-label">邮箱</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_email" name="email" required lay-verify="email"
                                           autocomplete="off" disabled value="{{$user->email}}" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_username" class="layui-form-label">昵称</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_username" name="name" required lay-verify="required"
                                           autocomplete="off" value="{{$user->name}}" class="layui-input">
                                </div>
                                <div class="layui-inline">
                                    <div class="layui-input-inline">
                                        <input type="radio" name="sex" value="1"
                                               {{$user->sex=='1'?'checked':''}} title="男">
                                        <input type="radio" name="sex" value="0"
                                               {{$user->sex=='0'?'checked':''}} title="女">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label for="L_sign" class="layui-form-label">签名</label>
                                <div class="layui-input-block">
                                    <textarea placeholder="随便写些什么刷下存在感" id="L_sign" name="sign" autocomplete="off"
                                              class="layui-textarea" style="height: 80px;">{{$user->sign}}</textarea>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="layui-form-item">
                                <button class="layui-btn" key="set-mine" lay-filter="info" lay-submit>确认修改</button>
                            </div>
                        </form>
                    </div>

                    <div class="layui-form layui-form-pane layui-tab-item">
                        <div class="layui-form-item">
                            <div class="avatar-add">
                                <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                                <button type="button" id="upload" class="layui-btn upload-img">
                                    <i class="layui-icon">&#xe67c;</i>上传头像
                                </button>
                                <img id="avatar" src="{{$user->avatar}}">
                                <span class="loading"></span>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form layui-form-pane layui-tab-item">
                        <form action="" method="post">
                            <div class="layui-form-item">
                                <label for="L_nowpass" class="layui-form-label">当前密码</label>
                                <div class="layui-input-inline">
                                    <input type="password" id="L_nowpass" name="nowpassword" required lay-verify="required"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_pass" class="layui-form-label">新密码</label>
                                <div class="layui-input-inline">
                                    <input type="password" id="L_pass" name="password" required lay-verify="required"
                                           autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">8到16个字符</div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_repass" class="layui-form-label">确认密码</label>
                                <div class="layui-input-inline">
                                    <input type="password" id="L_repass" name="repassword" required lay-verify="required"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="layui-form-item">
                                <button class="layui-btn" key="set-mine" lay-filter="setPass" lay-submit>确认修改</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['jquery', 'form','upload'], function () {
            var $ = layui.jquery
            var form = layui.form
            var upload = layui.upload

            var uploadInst = upload.render({
                elem: '#upload'
                ,url: '/upload-avatar' //改成您自己的上传接口
                ,before: function(obj){
                    obj.preview(function(index, file, result){
                        $('#avatar').attr('src', result);
                    });
                }
                ,done: function(res){
                    if(res.code > 0){
                        return layer.msg(res.msg);
                    }
                }
            });


            form.on('submit(info)', function (data) {
                $.ajax({
                    url: '/set-info',
                    method: 'post',
                    data: data.field,
                    dataType: 'JSON',
                    success: function (res) {
                        if(res.code==200){
                            layer.msg(res.msg)
                        }
                    }
                })
                return false
            })

            form.on('submit(setPass)', function (data) {
                $.ajax({
                    url: '/set-pass',
                    method: 'post',
                    data: data.field,
                    dataType: 'JSON',
                    success: function (res) {
                        if(res.code==200){
                            layer.msg(res.msg)
                        }else{
                            layer.msg(res.msg)
                        }
                    }
                })
                return false
            })

        })
    </script>
@endsection

