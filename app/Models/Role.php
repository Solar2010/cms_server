<?php

namespace App\Models;

class Role extends Base
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'role';

    protected $fillable = [
        'id',
        'admin_id',
        'name',
        'mark',
        'name',
        'weight'
    ];

    public function adminInfo()
    {
        return self::hasOne(Admin::class, 'id', 'admin_id');
    }

}
