<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/23
 * Time: 3:03 PM
 */

namespace App\Http\Controllers\Backend\Admin;


use App\Http\Controllers\Controller;
use App\Service\RoleService;
use Illuminate\Http\Request;

class Role extends Controller
{
    /**
     * 角色列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $uid = $this->uid;

        $list = (new RoleService())->getRoleList($uid, ['page' => $page, 'limit' => $limit]);

        return success($list);
    }

    /**
     * 添加角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addRole(Request $request)
    {
        $rule = [
            'name' => 'required',
            'mark' => 'sometimes'
        ];
        $data = $this->validate($request, $rule);
        $data['admin_id'] = $this->uid;
        $result = (new RoleService())->addRole($data);
        return success($result);
    }

    /**
     * 编辑角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function editRole(Request $request) {
        $rule = [
            'id' => 'required',
            'name' => 'required',
            'mark' => 'sometimes'
        ];
        $data = $this->validate($request, $rule);
        $result = (new RoleService()) ->editRole($data);
        return success($result);
    }

    /**
     * 删除角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delRole(Request $request)
    {
        $rule = [
            'id' => 'required'
        ];
        $data = $this->validate($request, $rule);

        $result = (new RoleService())->delRole($data['id']);

        return success($result);
    }

    /**
     * 给角色分配权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function allocPermission(Request $request)
    {
        $rule = [
            'role_id' => 'required',
            'permissions' => 'sometimes'
        ];

        $data = $this->validate($request, $rule);

        $result = (new RoleService())->allocPermission($data);

        return success($result);

    }

    /**
     * 根据角色ID返回数据权限ID
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getPermissionByRole(Request $request)
    {
        $rule = [
            'role_id' => 'required'
        ];
        $data = $this->validate($request, $rule);
        $result = (new RoleService())->getPermissionsByRole($data['role_id']);
        return success($result);
    }
}
