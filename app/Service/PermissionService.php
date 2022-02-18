<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/23
 * Time: 3:44 PM
 */

namespace App\Service;


use App\Models\Admin;
use App\Models\Permission;

class PermissionService
{
    public function getPermissionList($uid)
    {
        $admin = Admin::query()
            ->where([
                'id' => $uid
            ])
            ->first();

        if ($admin->is_super === Admin::ADMIN_TYPE[0]) {
            $permissions = Permission::query()
                ->get()
                ->toArray();
            $tree        = $this->tree($permissions);
        }
        return [ $permissions, $tree ];
    }

    /**
     * 获取权限树
     * @param $permissions
     * @param int $id
     * @param int $level
     * @return array
     */
    private function tree($permissions, $id = 0, $level = 0)
    {
        $tree = array();

        foreach ($permissions as $key => $value) {
            if ($value['pid'] == $id) {
                $value['level']    = $level + 1;
                $value['children'] = $this->tree($permissions, $value['id'], $value['level']);
                $tree[]            = $value;
                unset($permissions[$key]);
            }
        }

        return $tree;
    }

    /**
     * 添加权限
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function addPermission($data)
    {
        $data['pid'] = $data['id'];
        unset($data['id']);
        return Permission::query()
            ->create($data);
    }

    /**
     * 删除权限
     * @param $ids
     * @return mixed
     */
    public function delPermissions($ids)
    {
        return Permission::query()
            ->whereIn('id', $ids)
            ->delete();
    }
}
