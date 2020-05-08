@extends('layout.layout')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('common.user-info-nav',['type'=>$type])
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <table class="layui-table">
                    <colgroup>
                        <col width="200">
                        <col width="200">
                        <col width="200">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>总支出</th>
                        <th>总收入</th>
                        <th>可用余额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="color: red;">-{{$userWallet->outcome}}</td>
                        <td style="color: blue;">+{{$userWallet->income}}</td>
                        <td style="color: green;">{{$userWallet->balance_fee}}</td>
                    </tr>
                    </tbody>
                </table>
                <form class="layui-form">
                    <div class="layui-input-inline">
                        <input type="number" name="money" min="100" required lay-verify="required" placeholder="输入充值金额"
                               autocomplete="off" class="layui-input">
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button class="layui-btn" lay-submit lay-filter="recharge">立即充值</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        layui.use(['jquery', 'element', 'form'], function () {
            var $ = layui.jquery
            var form = layui.form
            form.on('submit(recharge)', function (data) {
                $.ajax({
                    url: '/recharge',
                    method: 'post',
                    data: data.field,
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.code == 200) {
                            window.location.href=res.data
                        }else{
                            layer.msg(res.data)
                        }
                    }
                })
                return false
            })
        });
    </script>
@endsection

