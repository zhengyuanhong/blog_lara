@extends('layout.layout')

@section('content')
    <div class="layui-container fly-marginTop fly-user-main">
        @include('common.user-info-nav',['type'=>$type])
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <table class="layui-table">
                    <colgroup>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>订单号</th>
                        <th>状态</th>
                        <th>类型</th>
                        <th>金额</th>
                        <th>结果</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userOrder as $v)
                        <tr>
                            <td>{{$v->trade_no}}</td>
                            <td>{{\App\Models\Order::$payStatusMap[$v->pay_status]}}</td>
                            <td>{{\App\Models\Order::$orderTypeMap[$v->type]}}</td>
                            <td>￥{{$v->price}}</td>
                            @if(empty($v->pay_at))
                                <td style="color: red;">支付失败</td>
                            @else
                                <td style="color: green;">支付成功</td>
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <td>总额</td>
                        <td style="color: green;">{{$total}}元</td>
                    </tr>
                    </tbody>
                </table>
                <div>
                    @if($userOrder->currentPage() == $userOrder->onFirstPage())
                    @else
                        <a href="{{$userOrder->previousPageUrl()}}">上一页</a>
                    @endif

                    @if($userOrder->currentPage() == $userOrder->lastPage())
                    @else
                        <a href="{{$userOrder->nextPageUrl()}}">下一页</a>
                    @endif
                </div>
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
                            window.location.href = res.data
                        } else {
                            layer.msg(res.data)
                        }
                    }
                })
                return false
            })
        });
    </script>
@endsection

