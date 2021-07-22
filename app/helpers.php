<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/22
 * Time: 10:26 AM
 */

if(!function_exists('success')) {
    function success($data) {
        return response()->json($data);
    }
}