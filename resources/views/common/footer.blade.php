<div class="fly-footer">
  <p><a href="{{$config['url']}}" target="_blank">{{$config['name']}}</a> 2020 &copy; <a href="http://www.layui.com/" target="_blank">{{$config['developer']}} 出品</a></p>
  <p>
    {{--<a href="" target="_blank">付费计划</a>--}}
    {{--<a href="" target="_blank">微信公众号</a>--}}
  </p>
</div>

<script src="/res/layui/layui.js"></script>
<script>
layui.cache.page = '';
layui.cache.user = {
  username: '游客'
  ,uid: -1
  ,avatar: '/res/images/avatar/00.jpg'
  ,experience: 83
  ,sex: '男'
};
layui.config({
  version: "3.0.0"
  ,base: '/res/mods/'  //这里实际使用时，建议改成绝对路径
}).extend({
  fly: 'index'
}).use('fly');
</script>