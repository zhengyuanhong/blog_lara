@extends('layout.layout')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('common.user-info-nav',['type'=>$type])
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
            <h1>充值中心</h1>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        layui.use(['jquery', 'element'], function () {
            var $ = layui.jquery

        });
    </script>
@endsection

