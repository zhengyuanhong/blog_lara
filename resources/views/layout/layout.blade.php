<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{isset($article->title)?$article->title:$config['name']}}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="{{$config['keywords']}}">
  <meta name="description" content="{{$config['desc']}}">
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