<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/test', function (Request $request) {
    echo 1;
});

//管理端登录
Route::post('login','LoginController@index');

//管理员模块
Route::namespace('Admin')->middleware(['api_auth'])->group(function () {
   Route::get('/admin/list', 'ListController@index');
   Route::get('/admin/role/list', 'RoleListController@index');
   Route::get('/admin/permission/list', 'PermissionController@index');
});