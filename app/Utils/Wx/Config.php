<?php

namespace App\Utils\Wx;

class Config
{
    public $appid;
    public $app_secret;
    public $my_plugin_id;
    public $notify_url = 'https://www.hellozheng.cn/notify';
    public $return_url = 'https://www.hellozheng.cn';
    public $callback_url = 'https://www.hellozheng.cn';
    public $url = 'https://api.xunhupay.com/payment/do.html';

    public function __construct()
    {
        $this->appid = config('util.wechat_pay.appid'); // '';
        $this->app_secret = config('util.wechat_pay.secret'); //'';
        $this->my_plugin_id = 'my-plugins-id';
    }

    public function dataFormat($data)
    {
        return [
            'version' => '1.1',//固定值，api 版本，目前暂时是1.1
            'lang' => 'zh-cn', //必须的，zh-cn或en-us 或其他，根据语言显示页面
            'plugins' => $this->my_plugin_id,//必须的，根据自己需要自定义插件ID，唯一的，匹配[a-zA-Z\d\-_]+
            'appid' => $this->appid, //必须的，APPID
            'trade_order_id' => $data['trade_order_id'], //必须的，网站订单ID，唯一的，匹配[a-zA-Z\d\-_]+
            'payment' => 'wechat',//必须的，支付接口标识：wechat(微信接口)|alipay(支付宝接口)
            'total_fee' => $data['total_fee'],//人民币，单位精确到分(测试账户只支持0.1元内付款)
            'title' => $data['title'], //必须的，订单标题，长度32或以内
            'time' => time(),//必须的，当前时间戳，根据此字段判断订单请求是否已超时，防止第三方攻击服务器
            'notify_url' => $this->notify_url, //必须的，支付成功异步回调接口
            'return_url' => $this->return_url, //'http://www.xx.com/pay/success.html',//必须的，支付成功后的跳转地址
            'callback_url' => $this->callback_url,  // 'http://www.xx.com/pay/checkout.html',//必须的，支付发起地址（未支付或支付失败，系统会会跳到这个地址让用户修改支付信息）
            'modal' => 'qrcode', //可空，支付模式 ，可选值( full:返回完整的支付网页; qrcode:返回二维码; 空值:返回支付跳转链接)
            'nonce_str' => str_shuffle(time())//必须的，随机字符串，作用：1.避免服务器缓存，2.防止安全密钥被猜测出来
        ];
    }

}
