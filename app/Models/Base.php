<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/9/27
 * Time: 5:22 PM
 */

namespace App\Models;


use App\Handlers\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use SoftDeletes;

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