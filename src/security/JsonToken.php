<?php
/**
 * Created by PhpStorm.
 * User: xiaomage
 * Date: 2020/12/16
 * Time: 17:35
 */

namespace App\Common\Security;

class JsonToken
{
    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * 头部
     * @var array
     */
    protected $header = array(
        'alg' => 'HS256', //生成signature的算法
        'typ' => 'JWT'  //类型
    );

    /**
     * 使用HMAC生成信息摘要时所使用的密钥
     * @var string
     */
    protected $key = 'fKwOLCXFrlkvVMjQgPRInUETx';

    /**
     * @return JsonToken|null
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * 设置秘钥
     * @param string $key
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     */
    protected function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        return $this->key;
    }

    /**
     * 公共的荷载参数
     * [
     * 'iss'=>'jwt_admin', //该JWT的签发者
     * 'iat'=>time(), //签发时间
     * 'exp'=>time()+7200, //过期时间
     * 'nbf'=>time()+60, //该时间之前不接收处理该Token
     * 'sub'=>'www.admin.com', //面向的用户
     * 'jti'=>md5(uniqid('JWT').time()) //该Token唯一标识
     * ]
     * @return array
     */
    protected function getPayload(): array
    {
        return [
            'iss' => 'bocai', //该JWT的签发者
            'iat' => time(), //签发时间
            'exp' => time() + 86400 * 7, //过期时间
            'sub' => 'user', //面向的用户
            'jti' => md5(uniqid('user') . time())
        ];
    }

    /**
     * 获取jwt token
     * @return string
     */
    public function make(): string
    {
        $payload = self::getPayload();

        $base64_header = $this->base64UrlEncode(json_encode($this->getHeader(), JSON_UNESCAPED_UNICODE));
        $base64_payload = $this->base64UrlEncode(json_encode($payload, JSON_UNESCAPED_UNICODE));

        return $base64_header . '.' . $base64_payload . '.' . $this->signature($base64_header . '.' . $base64_payload, $this->getKey(), $this->getHeader()['alg']);
    }

    /**
     * 验证token
     * @param string $token
     * @return bool|mixed
     */
    public function verify(string $token)
    {
        if (empty($token) || !is_string($token)) {
            return false;
        }

        [$base64_header, $base64_payload, $sign] = array_pad(explode('.', $token), 3, null);

        //获取jwt算法
        $base64_decode_header = json_decode($this->base64UrlDecode($base64_header), JSON_OBJECT_AS_ARRAY);
        if (empty($base64_decode_header['alg'])) {
            return false;
        }

        //签名验证
        if ($this->signature($base64_header . '.' . $base64_payload, $this->getKey(), $base64_decode_header['alg']) !== $sign) {
            return false;
        }

        $payload = json_decode($this->base64UrlDecode($base64_payload), JSON_OBJECT_AS_ARRAY);

        //签发时间大于当前服务器时间验证失败
        if (isset($payload['iat']) && $payload['iat'] > time()) {
            return false;
        }

        //过期时间小宇当前服务器时间验证失败
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }

        //该nbf时间之前不接收处理该Token
        if (isset($payload['nbf']) && $payload['nbf'] > time()) {
            return false;
        }

        return $payload;
    }


    /**
     * base64UrlEncode  https://jwt.io/ 中base64UrlEncode编码实现
     * @param string $input 需要编码的字符串
     * @return string
     */
    protected function base64UrlEncode(string $input): string
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * base64UrlEncode https://jwt.io/ 中base64UrlEncode解码实现
     * @param string $input 需要解码的字符串
     * @return bool|string
     */
    protected function base64UrlDecode(string $input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $add_length = 4 - $remainder;
            $input .= str_repeat('=', $add_length);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * HMACSHA256签名  https://jwt.io/ 中HMACSHA256签名实现
     * @param string $input
     * @param string $key
     * @param string $alg
     * @return string
     */
    protected function signature(string $input, string $key, string $alg = 'HS256')
    {
        $alg_config = array(
            'HS256' => 'sha256'
        );
        return $this->base64UrlEncode(hash_hmac($alg_config[$alg], $input, $key, true));
    }
}
