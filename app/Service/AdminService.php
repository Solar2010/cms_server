<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/20
 * Time: 9:20 AM
 */

namespace App\Service;


use App\Lib\Utils;
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
            return notice(200003);
        }
        $inputPassword = $this->generatePassword($this->admin['salt'], $password);
        if($inputPassword != $this->admin['password']) {
            return notice(200004);
        }
        return $this->admin;

    }

    /**
     * 密码加密规则
     * @param $password
     * @return string
     */
    public function generatePassword($salt, $password)
    {
        return md5($salt . $password);
    }


    /**
     * 获取管理员列表
     * @param $adminId
     * @param $pageOption
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAdminList($adminId, $pageOption)
    {
        $this->admin = Admin::query()->where(['id' => $adminId])
            ->first();
        if(is_null($this->admin)) {
            response()->json('管理员不存在', 500);
        }
        return Admin::query()
            ->paginate($pageOption['limit'], '*', '', $pageOption['page']);
    }

    /**
     * 启用|禁用管理员
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function changeAdminStatus($id)
    {
        $this->admin = Admin::query()->where(['id' => $id])
            ->first();
        if(is_null($this->admin)) {
            return response()->json('管理员不存在', 500);
        }

        return Admin::query()
            ->where(['id' => $id])
            ->update(['status' => $this->admin->status == 1 ? 2 : 1]);
    }

    /**
     * 添加管理员
     * @param $data
     * @return array|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function addAdmin($data)
    {
        $admin = Admin::query()
            ->where('account', $data['account'])
            ->first();
        if(is_null($admin)) {
            $salt = (new Utils())->generateSalt(4);
            $data['password'] = $this->generatePassword($salt, $data['password']);
            return Admin::query()
                ->create($data);
        }
        return notice(200002);
    }

    /**
     * 删除管理员
     * @param $id
     * @return mixed
     */
    public function deleteAdmin($id)
    {
        $admin = Admin::query()
            ->where('id', $id)
            ->first();
        if(is_null($admin)) {
            return notice(200003);
        }
        return Admin::query()
            ->where('id', $id)
            ->delete();
    }
}