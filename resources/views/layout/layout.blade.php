<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>蔓枝</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="fly,layui,前端社区">
  <meta name="description" content="Fly社区是模块化前端UI框架Layui的官网社区，致力于为web开发提供强劲动力">
  @include('common.link')
</head>
<body>

@include('common.header')

@yield('content')

@include('common.footer')

@section('script')
@show
</body>
</html>