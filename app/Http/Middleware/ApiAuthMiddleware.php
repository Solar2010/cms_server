<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/22
 * Time: 11:25 AM
 */

namespace App\Http\Middleware;

use Closure;
use App\Lib\JwtAuth;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{
    public $token = null;

    public $uid = null;

    public function __construct(Request $request)
    {
        if($request->hasHeader('Token')) {
            $this->token = $request->header('Token');
        }
    }

    /**
     * 验证token
     * @param $token
     * @return bool
     */
    private function verifyToken($token)
    {
        try {
            if(JwtAuth::getInstance()->setToken($token)->validate()) {
                return true;
            }
        } catch (\Exception $e) {
            dd($e);
        }

        return false;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            if (is_null($this->token)) {
                return response()->json([ [ 'data' => [], 'message' => '未检测到有效的token' ]], 500 );
            }
            if (!$this->verifyToken($this->token)) {
                return response()->json([ [ 'data' => [], 'message' => 'token校验失败' ]], 401 );
            }
        } catch (\Exception $e) {
            return response()->json([ [ 'data' => [], 'message' => $e->getMessage() ]], 400 );
        }
        return $next($request);
    }
}