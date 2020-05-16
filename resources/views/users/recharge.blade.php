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
                        <input type="radio" name="money" value="1" title="1元">
                        <input type="radio" name="money" value="2" title="2元">
                        <input type="radio" name="money" value="5" title="5元">
                        <input type="radio" name="money" value="10" title="10元">
                        <input type="radio" name="money" value="30" title="30元">
                        <input type="radio" name="money" value="50" title="50元">
                        <input type="radio" name="money" value="80" title="80元">
                        <input type="radio" name="money" value="100" title="100元">
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

