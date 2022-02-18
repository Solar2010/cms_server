<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/23
 * Time: 3:08 PM
 */

namespace App\Service;


use App\Models\Role;
use App\Models\RolePermission;

class RoleService
{
    /**
     * 获取角色列表
     * @param $adminId
     * @param $pageOption
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getRoleList($adminId, $pageOption)
    {
        return Role::query()
            ->with('adminInfo')
            ->where(['admin_id' => $adminId])
            ->paginate($pageOption['limit'], '*', '', $pageOption['page']);
    }

    /**
     * 新增角色
     * @param $params
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function addRole($params)
    {
        return Role::query()
            ->create($params);
    }

    /**
     * 编辑角色
     * @param $params
     * @return int
     */
    public function editRole($params)
    {
        $id = $params['id'];
        unset($params['id']);
        return Role::query()
            ->where('id', $id)
            ->update($params);
    }

    /**
     * 删除角色
     * @param $id
     * @return mixed
     */
    public function delRole($id)
    {
        return Role::query()
            ->where('id', $id)
            ->delete();
    }

    /**
     * 给角色分配权限
     * @param $data
     * @return array
     */
    public function allocPermission($data)
    {
        if(empty($data['permissions'])) {
            return [];
        }
        //删除原来数据关系
         RolePermission::query()
            ->where('role_id', $data['role_id'])
            ->delete();
        foreach ($data['permissions'] as $val) {
            RolePermission::query()
                ->create([
                    'role_id' => $data['role_id'],
                    'permission_id' => $val
                ]);
        }
        return [];
    }

    /**
     * 根据角色ID返回权限ID
     * @param $roleId
     * @return array
     */
    public function getPermissionsByRole($roleId)
    {
        $permissions =  RolePermission::query()
            ->where('role_id', $roleId)
            ->select(['permission_id'])
            ->get()
            ->toArray();
        if(empty($permissions)) {
            return [];
        }
        return array_values(array_column($permissions, 'permission_id'));
    }
}
