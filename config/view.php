<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

    'web_config'=>[
        'name'=>env('NAME','松语'),
        'keywords'=>env('KEYWORDS','左治理，记录生活'),
        'desc'=>env('DESC','青年时种下什么,老年时就收获什么'),
        'icp'=>env('ICP','赣ICP备18013848号-1'),
        'developer'=>env('DEVELOPER','zhengyuanhong'),
        'url'=>env('APP_URL','http://www.hellozheng.cn')
    ]
];
