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
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $uid = $this->uid;

        $list = (new RoleService())->getRoleList($uid, ['page' => $page, 'limit' => $limit]);

        return success($list);
    }
}