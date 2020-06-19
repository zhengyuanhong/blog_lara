<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <a class="fly-logo" href="/">
            {{--<img src="/res/images/logo.png" alt="layui">--}}
            <text style="color: white;font-weight: bold;font-size: 30px;">{{$config['name']}}</text>
        </a>
        {{--<ul class="layui-nav fly-nav layui-hide-xs">--}}
        {{--<li class="layui-nav-item layui-this">--}}
        {{--<a href="{{url('/users/info')}}"><i class="iconfont icon-jiaoliu"></i>交流</a>--}}
        {{--</li>--}}
        {{--<li class="layui-nav-item">--}}
        {{--<a href="case/case.html"><i class="iconfont icon-iconmingxinganli"></i>案例</a>--}}
        {{--</li>--}}
        {{--<li class="layui-nav-item">--}}
        {{--<a href="http://www.layui.com/" target="_blank"><i class="iconfont icon-ui"></i>框架</a>--}}
        {{--</li>--}}
        {{--</ul>--}}

        <ul class="layui-nav fly-nav-user">

            @guest
                <!-- 未登入的状态 -->
                <li class="layui-nav-item">
                    <a class="iconfont icon-touxiang layui-hide-xs" href="{{url('login')}}"></a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{url('login')}}">登入</a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{url('reg')}}">注册</a>
                </li>
            @endguest

            @auth
                <!-- 登入后的状态 -->
                <li class="layui-nav-item">
                    <a class="fly-nav-avatar" href="javascript:;">
                        @if(request()->user()->unreadNotifications->count() > 0)
                        <i class="layui-badge fly-badge-vip layui-hide-xs">{{request()->user()->unreadNotifications->count()}}</i>
                        @endif
                        <cite class="layui-hide-xs">{{request()->user()->name}}</cite>
                        <img src="{{request()->user()->avatar}}">
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{route('user.detail',['user'=>request()->user()->id])}}"><i class="layui-icon"
                                                                                                  style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a>
                        </dd>
                        <dd><a href="{{route('user.set')}}"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                        <dd><a style="text-align: center;" href="{{route('user.message')}}">我的消息：<span style="color: red;">{{request()->user()->unreadNotifications->count()}}</span></a>
                        </dd>

                        <dd><a style="text-align: center;" href="{{route('user.recharge')}}">余额：<span style="color: red;">{{request()->user()->wallet->balance_fee}}元</span></a>
                        </dd>

                        <hr style="margin: 5px 0;">
                        <dd><a href="{{url('/logout')}}" style="text-align: center;">退出</a></dd>
                    </dl>
                </li>
            @endauth
        </ul>
    </div>
</div>