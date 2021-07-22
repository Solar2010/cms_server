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
        if(JwtAuth::getInstance()->setToken($token)->validate()) {
            return true;
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
        if(is_null($this->token)) {
            response()->json([['data' => [], 'message' => '未检测到有效的token'], 500]);
        }
        if(!$this->verifyToken($this->token)) {
            response()->json([['data' => [], 'message' => 'token校验失败'], 401]);
        }
        return $next($request);
    }
}