<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/23
 * Time: 3:08 PM
 */

namespace App\Service;


use App\Models\Role;

class RoleService
{
    public function getRoleList($adminId, $pageOption)
    {
        return Role::query()
            ->where(['admin_id' => $adminId])
            ->paginate($pageOption['limit'], '*', '', $pageOption['page']);
    }
}