<?php

namespace App\Http\Controllers;

use App\Lib\JwtAuth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $token = null;

    public $uid = null;
    public function __construct(Request $request)
    {
        if($request->hasHeader('Token')) {
            $this->token = $request->header('Token');
        }

        $this->uid = JwtAuth::getInstance()->setToken($this->token)->decode()->getClaim('uid');
    }
}
