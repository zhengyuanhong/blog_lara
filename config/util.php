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
    ]
];
