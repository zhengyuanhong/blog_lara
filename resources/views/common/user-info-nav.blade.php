<ul class="layui-nav layui-nav-tree  layui-inline"  lay-filter="user">
    <li class="layui-nav-item {{$type=='user'? 'layui-this':''}}">
      <a href="{{route('user.detail',['user'=>Request()->user()->id])}}">
        <i class="layui-icon">&#xe609;</i>
        我的主页
        </a>
    </li>
    <li class="layui-nav-item {{$type=='set'? 'layui-this':''}}">
        <a href="{{route('user.set')}}">
            <i class="layui-icon">&#xe620;</i>
            基本设置
        </a>
    </li>
    <li class="layui-nav-item {{$type=='info'? 'layui-this':''}}">
      <a href="{{route('user.home')}}">
        <i class="layui-icon">&#xe612;</i>
        用户中心
        </a>
    </li>
    <li class="layui-nav-item {{$type=='message'? 'layui-this':''}}">
        <a href="{{route('user.message')}}">
        <i class="layui-icon">&#xe611;</i>
        我的消息
        </a>
    </li>
  </ul>

  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>

  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
