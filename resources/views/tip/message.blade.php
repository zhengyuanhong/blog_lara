@extends('layout.layout')

@section('content')
    <div class="layui-container fly-marginTop">
        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                    @if(!empty($msg))
                        {{$msg}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection