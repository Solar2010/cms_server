<?php

namespace App\Models;


class Admin extends Base
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'admin';

    protected $fillable = [
        'id',
        'username',
        'account',
        'password',
        'salt',
        'email',
        'mobile',
        'is_super',
        'last_login_time',
        'operate_id',
        'status',
        'range_type'
    ];

    /**
     * 管理员状态，1：启用 2：禁用
     */
    const ADMIN_STATUS = [1, 2];

    /**
     * 管理员类型 1：超级管理员 2：普通管理员
     */
    const ADMIN_TYPE = [1, 2];
}
