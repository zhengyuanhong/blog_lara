<?php

namespace App\Utils;
use Illuminate\Support\Facades\Log;

require_once(__DIR__ . '/../Helper/Ucloud/proxy.php');

class Ucloud
{
    //存储空间名
    protected $bucket = "imagesfilm";
//上传至存储空间后的文件名称(请不要和API公私钥混淆)
    protected $key = "";
//待上传文件的本地路径
    protected $file = "";
//当前append 的文件已有的大小, 新建填0
    protected $position = 0;

    public function __construct($key,$file)
    {
        $this->key = $key;
        $this->file = storage_path('app/public/'.$file);;
    }

    public function upload()
    {
        list($data,$err) = UCloud_PutFile($this->bucket,$this->key,$this->file);
        if ($err) {
            Log::error("error: " . $err->ErrMsg . "\n");
            Log::error("code: " . $err->Code . "\n");
            return $err;
        }
        return $data;
    }

    public function getKey($key){
        $res = $this->upload();
        Log::info('key::'.$res['ETag']);
        $src = config('util.ucloud.http').$key;
        return $src;
    }
}

