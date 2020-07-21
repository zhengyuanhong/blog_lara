<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{isset($article->title)?$article->title:$config['name']}}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="生活记录，生活分享，笔记内容，照片分享">
  <meta name="description" content="在生活中要像松树一样，不言不语，静默，深沉，它有着茁壮的树干，它有着强大的内心，它的强大是低调的，它虽然不言不语，但它的一切都是天地可鉴的">
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