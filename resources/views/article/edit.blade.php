@extends('layout.layout')

@section('content')
    <div class="layui-container fly-marginTop">
        <div class="fly-panel" pad20 style="padding-top: 5px;">
            <!--<div class="fly-none">没有权限</div>-->

            <div class="layui-form layui-form-pane">
                <div class="layui-tab layui-tab-brief" lay-filter="user">
                    <ul class="layui-tab-title">
                        <li class="layui-this">编辑文章<!-- 编辑帖子 --></li>
                    </ul>
                    <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                        <div class="layui-tab-item layui-show">
                            <form action="/detail/edit" method="post">
                                <div class="layui-row layui-col-space15 layui-form-item">
                                    <div class="layui-col-md4">
                                        <label class="layui-form-label">所在专栏</label>
                                        <div class="layui-input-block">
                                            <select lay-verify="required" name="category_id" lay-filter="column">
                                                    <option value="{{$article->category->id}}">{{$article->category->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-col-md8">
                                        <label for="L_title" class="layui-form-label">标题</label>
                                        <div class="layui-input-block">
                                            <input type="text" id="L_title" value="{{$article->title}}" name="title"
                                                   autocomplete="off" class="layui-input">
                                            <!-- <input type="hidden" name="id" value="d.edit.id"> -->
                                        </div>
                                    </div>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li style="padding:5px;color: red;font-size: 20px;">{{ $error }}!</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="layui-form-item layui-form-text">
                                    <div class="layui-input-block">
                                        <textarea id="L_content" name="content"
                                                  placeholder="详细描述" class="layui-textarea"
                                                  style="height: 260px;">{{$article->content}}</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <input type="hidden" name="id" value="{{$article->id}}"/>
                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-filter="edit" lay-submit>立即更新</button>
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
        layui.use(['layedit', 'form', 'jquery', 'element'], function () {
            var layedit = layui.layedit
            var form = layui.form
            var $ = layui.jquery
            var element = layui.element

            layedit.set({
                uploadImage: {
                    url: '/upload-image',
                    exts: 'jpg|png|gif|bmp|jpeg',
                    size: '10240'
                }
                //开发者模式 --默认为false
                , devmode: false
                //插入代码设置
                , tool: [
                    'strong', 'italic', 'underline', 'del', 'addhr', '|', 'fontFomatt', 'colorpicker', 'face'
                    , '|', 'left', 'center', 'right', '|', 'link','unlink','image'],
                height:500
            });
            var index = layedit.build('L_content')

            form.verify({
                required: function (value) {
                    return layedit.sync(index)
                }
            })

            // form.on('submit(add)', function (data) {
            //     $.ajax({
            //         url: '/article-add',
            //         method: 'post',
            //         data: data.field,
            //         dataType: 'JSON',
            //         success: function (res) {
            //             if (res.code == 200) {
            //                 layer.msg((res.msg));
            //                 $('#L_content').val('')
            //                 setTimeout(function () {
            //                     window.location.href = "/"
            //                 }, 500)
            //             } else {
            //                 layer.msg(res);
            //             }
            //         }
            //     });
            //     return false
            // })
        });
    </script>
@endsection
