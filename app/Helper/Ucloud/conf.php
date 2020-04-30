<?php
global $SDK_VER;
global $UCLOUD_PROXY_SUFFIX;
global $UCLOUD_PUBLIC_KEY;
global $UCLOUD_PRIVATE_KEY;

$SDK_VER = "1.0.8";

//空间域名后缀,请查看控制台上空间域名再配置此处
//https://docs.ucloud.cn/storage_cdn/ufile/tools/introduction
$UCLOUD_PROXY_SUFFIX = '.cn-bj.ufileos.com';      //如果是其他地域的，请参考上面的说明

$UCLOUD_PUBLIC_KEY =config('util.ucloud.public_key');
$UCLOUD_PRIVATE_KEY =config('util.ucloud.private_key');
