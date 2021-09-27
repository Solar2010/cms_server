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
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * 权限列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        list($permissions, $tree) = (new PermissionService())->getPermissionList($this->uid);

        return success(['permissions' => $permissions, 'tree' => $tree]);
    }

    /**
     * 添加权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addPermission(Request $request)
    {
        $rule = [
            'id' => 'required|integer',
            'name' => 'required',
            'path' => 'required',
            'icon' => 'sometimes'
        ];
        $data = $this->validate($request, $rule);
        $result = (new PermissionService())->addPermission($data);

        return success($result);
    }
}