<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/9/27
 * Time: 3:21 PM
 */

namespace App\Lib;


class Utils
{

    /**
     * 通过mt_rand获取指定长度的随机字符串
     * @param $length
     * @return string
     */
    public function generateSaltByMtRand($length)
    {
        $str = 'abcdefghigklmnopqrstuvwxyz';
        $len = strlen($str) - 1;
        $randStr = '';
        for ($i = 0; $i <  $length; $i ++) {
            $num = mt_rand(0, $len);
            $randStr .= $str[$num];
        }
        return $randStr;
    }

    /**
     * 通过array_rand生成指定长度的随机字符串
     * @param $length
     * @return string
     */
    public function generateSaltByArrayRand($length)
    {
        $str = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y','z');
        $keys = array_rand($str, $length);
        $randStr = '';
        for ($i = 0; $i < $length; $i ++) {
            $randStr .= $str[$keys[$i]];
        }
        return $randStr;
    }

    /**
     * 通过打乱字符串截取指定长度的随机字符串
     * @param $length
     * @return bool|string
     */
    public function generateSalt($length)
    {
        $str = 'abcdefghigklmnopqrstuvwxyz';
        $rands = str_shuffle($str);
        $randStr = substr($rands, 0, $length);
        return $randStr;
    }



}