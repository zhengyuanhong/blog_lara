@extends('layout.layout')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('common.user-info-nav',['type'=>$type])
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <li data-type="mine-jie" lay-id="index" class="layui-this">我发的文章（<span>{{$article_num}}</span>）</li>
                    <li data-type="collection" data-url="/collection/find/" lay-id="collection">
                        我收藏的文章（<span>{{$favorite_num}}</span>）
                    </li>
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-tab-item layui-show">
                        <ul id="my_articles" class="mine-view jie-row">
                        </ul>
                        <div id="LAY_page">
                            <span id="pre_page_article"><button type="button" class="layui-btn layui-btn-xs">上一页</button></span>
                            <span id="next_page_article"><button type="button" class="layui-btn layui-btn-xs">下一页</button></span>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <ul id="my_favorite_articles" class="mine-view jie-row">
                        </ul>
                        <div id="LAY_page1">
                            <span id="pre_page"><button type="button" class="layui-btn layui-btn-xs">上一页</button></span>
                            <span id="next_page"><button type="button" class="layui-btn layui-btn-xs">下一页</button></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        layui.use(['jquery', 'element'], function () {
            var $ = layui.jquery
            var element = layui.element
            var page = 1 ,favorite_article_page = 1;

            var getArticle = function (page = 1) {
                $.ajax({
                    url: '/own-article',
                    method: 'get',
                    data: {
                        page: page
                    },
                    dataType: 'JSON',
                    success: function (res) {
                        console.log(res)
                        if (res.code == 200) {
                            if(res.data.length != 0){
                                $('#next_page_article').show()
                                var str = ''
                                res.data.forEach(function (val, index) {
                                    str+=`
                                    <li>
                                    <a class="jie-title" href="/detail/${val.id}" target="_blank">${val.title}</a>
                                <i>${val.comment_num}评论</i>
                                <a class="mine-edit" href="/detail/edit/${val.id}">编辑</a>
                                    <em>${val.created_at}</em>
                                </li>`

                                    $('#my_articles').html(str)
                                })
                            }else{
                                $('#next_page_article').hide()
                                $('#my_articles').html('<div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表任何文章</i></div>')
                            }

                        } else {
                            layer.msg(res);
                        }
                    }
                });
            }
            getArticle()

            $('#next_page_article').click(function () {
                page += 1
                getArticle(page)
            })

            $('#pre_page_article').click(function () {
                page -= 1
                if (page <= 0) {
                    page = 1
                }
                getArticle(page)
            })

            var getFavoriteArticle = function(favorite_article_page=1){
                $.ajax({
                    url: '/favorite-article',
                    method: 'get',
                    data: {
                        page: favorite_article_page
                    },
                    dataType: 'JSON',
                    success: function (res) {
                        console.log(res)
                        if (res.code == 200) {
                            if(res.data.length != 0){
                                $('#next_page').show()
                                var str1 = ''
                                res.data.forEach(function (val, index) {
                                    str1 += `<li>
                                <a class="jie-title" href="/detail/${val.id}" target="_blank">${val.title}</a>
                                <i>${val.created_at}</i></li>`
                                    $('#my_favorite_articles').html(str1)
                                })
                            }else{
                                $('#next_page').hide()
                                $('#my_favorite_articles').html('<div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有收藏任何文章</i></div>')
                            }
                        } else {
                            layer.msg(res);
                        }
                    }
                });
            }

            getFavoriteArticle()

            $('#next_page').click(function () {
                favorite_article_page += 1
                getFavoriteArticle(favorite_article_page)
            })

            $('#pre_page').click(function () {
                favorite_article_page -= 1
                if (favorite_article_page <= 0) {
                    favorite_article_page = 1
                }
                getFavoriteArticle(favorite_article_page)
            })

        });
    </script>
@endsection

