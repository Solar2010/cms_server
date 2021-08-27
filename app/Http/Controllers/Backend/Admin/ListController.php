<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/23
 * Time: 2:19 PM
 */

namespace App\Http\Controllers\Backend\Admin;


use App\Http\Controllers\Controller;
use App\Service\AdminService;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * 管理员列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 1);
        $uid = $this->uid;
        $list = (new AdminService())->getAdminList($uid, ['page' => $page, 'limit' => $limit]);
        return success($list);
    }

    /**
     * 启用|禁用管理员
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $id = $request->get('id');

        (new AdminService())->changeAdminStatus($id);

        return success([]);
    }
}