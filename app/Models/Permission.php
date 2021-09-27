<?php

namespace App\Models;


class Permission extends Base
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'permission';

    protected $fillable = ['pid', 'name', 'path', 'key', 'icon', 'type', 'weight', 'api_list'];
}
