<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/20
 * Time: 9:20 AM
 */

namespace App\Service;


use App\Models\Admin;

class AdminService
{
    /**
     * 管理员对象
     * @var null
     */
    public $admin = null;

    /**
     * 通过用户名和密码检测管理员
     * @param $account
     * @param $password
     * @return bool
     */
    public function checkAdmin($account, $password)
    {
        $this->admin = Admin::query()
            ->where([
                'account' => $account,
                'status'  => Admin::ADMIN_STATUS[0]
            ])
            ->first();
        if(is_null($this->admin)) {
            return false;
        }
        $inputPassword = $this->generatePassword($password);
        if($inputPassword != $this->admin['password']) {
            return false;
        }
        return $this->admin;

    }

    /**
     * 密码加密规则
     * @param $password
     * @return string
     */
    public function generatePassword($password)
    {
        return md5($this->admin['salt'] . $password);
    }
}