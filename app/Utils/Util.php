<?php

namespace App\Utils;

class Util
{
    public function timeFormat($time)
    {
        if (empty($time)) {
            return '-';
        }
        $timestamp = strtotime($time);
        $difference = time() - $timestamp;
        if ($difference <= 180) {
            return '刚刚';
        } elseif ($difference <= 3600) {
            return ceil($difference / 60) . '分钟前';
        } elseif ($difference <= 86400) {
            return ceil($difference / 3600) . '小时前';
        } elseif ($difference <= 2592000) {
            return ceil($difference / 86400) . '天前';
        } elseif ($difference <= 31536000) {
            return ceil($difference / 2592000) . '个月前';
        } else {
            return $time;
        }
    }

    public function dealReply($str)
    {
        //判断是回复人
        if (substr($str, 0, 1) != '@') {
            return ['username' => null, 'content' => $str];
        }

        $arr = explode(' ', $str);
        //@username
        $username = substr($arr[0], 1);
        unset($arr[0]);
        $newStr = '';
        foreach ($arr as $v) {
            $newStr .= $v;
        }
        return ['username' => $username, 'content' => $newStr];
    }
}


