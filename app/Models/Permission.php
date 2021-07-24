<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'permission';

    /**
     * 指示模型是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 模型日期列的存储格式。
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 需要被转换日期时间格式的字段
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
