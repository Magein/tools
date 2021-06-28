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
    private static $code = null;

    /**
     * @var string
     */
    private static $message = null;

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
     * @param $code
     * @return mixed
     */
    public static function code($code = null)
    {
        if ($code) {
            self::$code = $code;
        } else {
            return self::$code;
        }
    }

    /**
     * @param string|null $message
     * @return mixed
     */
    public static function message(string $message = null)
    {
        if ($message !== null) {
            self::$message = $message;
        } else {
            return self::$message;
        }
    }

    /**
     * @param $code
     * @param $message
     */
    public static function set($code, $message)
    {
        self::$code = $code;
        self::$message = $message;
    }

    /**
     * @return array
     */
    public static function get()
    {
        return [
            'code' => self::$code,
            'message' => self::$message
        ];
    }

    /**
     * 清除
     */
    public static function clear()
    {
        self::$code = null;
        self::$message = null;
    }
}