<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/7/22
 * Time: 10:53 AM
 */

namespace App\Lib;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class JwtAuth
{
    private static $instance;
    // 加密后的token
    private $token;
    // 解析JWT得到的token
    private $decodeToken;
    // 用户ID
    private $uid;

    // jwt参数
    private $iss = 'http://example.com';//该JWT的签发者
    private $aud = 'http://example.org';//配置听众
    private $id = '4f1g23a12aa';//配置ID（JTI声明）

    /**
     * 获取token
     * @return string
     */
    public function getToken()
    {
        return (string)$this->token;
    }

    /**
     * 设置类内部 $token的值
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }


    /**
     * 设置uid
     * @param $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * 得到 解密过后的 uid
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * 加密jwt
     * @return $this
     */
    public function encode()
    {
        $time        = time();
        $this->token = (new Builder())
            ->setSubject($this->iss)
            ->setAudience($this->aud)
            ->setId($this->id, true)
            ->setIssuedAt($time)
            ->setNotBefore($time)
            ->setExpiration($time + env('JWT_TTL'))
            ->set('uid', $this->uid)
            ->sign(new Sha256(), env('JWT_SECRET'))
            ->getToken(); // Retrieves the generated token

        return $this;
    }


    /**
     * 解密token
     * @return \Lcobucci\JWT\Token
     * @throws \Exception
     */
    public function decode()
    {
        if (!$this->decodeToken) {
            $this->decodeToken = (new Parser())->parse((string)$this->token);
            $this->uid         = $this->decodeToken->getClaim('uid');
        }


        return $this->decodeToken;

    }


    /**
     * 验证令牌是否有效
     * @return bool
     */
    public function validate()
    {
        $data = new ValidationData();
        $data->setAudience($this->aud);
        $data->setIssuer($this->iss);
        $data->setId($this->id);
        return $this->decode()->validate($data);
    }

    /**
     * 验证令牌在生成后是否被修改
     * @return bool
     */
    public function verify()
    {
        $res = $this->decode()->verify(new Sha256(), env('JWT_SECRET'));
        return $res;
    }


    /**
     * 该类的实例
     * @return JwtAuth
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 单例模式 禁止该类在外部被new
     * JwtAuth constructor.
     */
    private function __construct()
    {
    }

    /**
     * 单例模式 禁止外部克隆
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
}