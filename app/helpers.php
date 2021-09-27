<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/22
 * Time: 10:26 AM
 */
use App\Exceptions\Error;

if(!function_exists('success')) {
    function success($data) {
        return response()->json($data);
    }
}
if (!function_exists('message')) {
    function message($code, $args)
    {
        if (is_numeric($code)) {
            if (empty(config('code.' . $code)) && empty($args)) {
                $message = '未知的错误';
            } else if (!empty(config('code.' . $code)) && !empty($args)) {
                $message = config('code.' . $code);
            } else if (!empty($args)) {
                $message = '%s';
            } else {
                $message = config('code.' . $code);
            }
        } else {
            $config  = config('notice.' . $code);
            $arr     = explode('|', $config);
            $message = $arr[1];
            $code    = $arr[0];
        }

        if (!empty($args)) {
            $message = vsprintf($message, $args);
        }

        return [$code, $message];
    }
}
if (!function_exists('notice')) {
    function notice($code, $args = [], $data = [], $httpCode = 200, $definedError = '')
    {
        list($code, $message) = message($code, $args);

        if (!empty($args)) {
            $message = vsprintf($message, $args);
        }
        if (!empty($definedError)) {
            $message = $definedError;
        }
        throw new Error($code, $message, $data, $httpCode);
    }
}