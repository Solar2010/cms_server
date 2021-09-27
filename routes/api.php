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
   Route::post('/admin/add', 'ListController@add');
   Route::get('/admin/delete/{id}', 'ListController@delete');
   Route::get('/admin/change-status', 'ListController@changeStatus');
   Route::get('/admin/role/list', 'Role@index');
   Route::get('/admin/permission/list', 'PermissionController@index');
   Route::post('/admin/permission/add', 'PermissionController@addPermission');
});