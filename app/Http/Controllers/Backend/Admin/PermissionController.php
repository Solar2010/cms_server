<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/23
 * Time: 3:35 PM
 */

namespace App\Http\Controllers\Backend\Admin;


use App\Http\Controllers\Controller;
use App\Service\PermissionService;

class PermissionController extends Controller
{
    public function index()
    {
        list($permissions, $tree) = (new PermissionService())->getPermissionList($this->uid);

        return success(['permissions' => $permissions, 'tree' => $tree]);
    }
}