<?php

return [
    'ucloud' => [
        'public_key' => env('U_PUBLIC_KEY', 'key'),
        'private_key' => env('U_PRIVATE_KEY', 'key'),
        'http' => env('U_HTTP', 'http://imagesfilm.cn-bj.ufileos.com/')
    ],
    'qiniu' => [

    ],
    'wechat_pay' => [
        'appid' => env('PAY_APPID'),
        'secret' => env('PAY_SECRET'),
    ],
    'wei_bo'=>[
        'client_id'=>'4009978008',
        'client_secret'=>'23250329e4826c46fe87c6d2aaba50e8',
//        'redirect_url'=>'http://www.hellozheng.cn/notify',
        'redirect_url'=>'http://127.0.0.1/callback',
        'user_id_api'=>'https://api.weibo.com/2/account/get_uid.json',
    ]
];
