<?php
/**
 * Created by PhpStorm.
 * User: xiaomage
 * Date: 2020/12/15
 * Time: 10:43
 */

namespace magein\tools\common;

/**
 * 消息传递工具
 * Class MsgDeliver
 * @package common
 */
class MsgDeliver
{

    /**
     * @var int
     */
    public static $code = null;

    /**
     * @var string
     */
    public static $message = null;

    /**
     * 防止实例化
     * ApiError constructor.
     */
    protected function __construct()
    {
    }

    /**
     * 防止克隆
     */
    protected function __clone()
    {
    }

    /**
     * @param int $code
     * @param string $message
     */
    public static function set($code = null, $message = null)
    {
        self::$code = $code;
        self::$message = $message;
    }

    /**
     * @return array
     */
    public function get()
    {
        return [
            'code' => self::$code,
            'message' => self::$message
        ];
    }

    /**
     * 清除
     */
    public function clear()
    {
        self::$code = null;
        self::$message = null;
    }
}