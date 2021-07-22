<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/19
 * Time: 4:19 PM
 */

namespace App\Http\Controllers\Backend;


use App\Events\User;
use App\Lib\JwtAuth;
use App\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController
{
    public function index(Request $request)
    {
        $rules = [
            'account' => 'required',
            'password' => 'required'
        ];

        $message = [
            'account.required' => '账户信息必填',
            'password.required' => '密码不能为空'
        ];
        $params = $request->post();

        $validator = Validator::make($params, $rules, $message);

        if(!$validator->fails()) {
            //登录验证
            if($admin = (new AdminService())->checkAdmin($params['account'], $params['password'])) {
                //生成token
                $admin->token = JwtAuth::getInstance()->setUid($admin->id)->encode()->getToken();
                unset($admin->salt, $admin->created_at, $admin->updated_at, $admin->deleted_at);

                //更新最后一次登录时间
                event(new User($admin, time()));
                return success($admin);
            }

        }
    }
}