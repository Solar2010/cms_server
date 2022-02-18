<?php

namespace App\Models;


class RolePermission extends Base
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'role_permission';

    protected $fillable = ['role_id', 'permission_id'];
}
