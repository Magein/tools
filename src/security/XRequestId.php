<?php

namespace magein\tools\security;

use magein\tools\common\RandomString;

class XRequestId
{
    /**
     * @var string
     */
    private static $key = '2zm38w4zkMy7q4zV2hFuWbJ11FKhVk03';


    /**
     * 生成 request_id
     * @param null $key
     * @return string
     */
    public static function make($key = null)
    {
        if (empty($key)) {
            $key = self::$key;
        }

        $string = RandomString::make(12);
        $timestamp = time();
        $sign = $key . $string . $timestamp;
        return $string . '.' . md5($sign) . '.' . time();
    }

    /**
     * @param string $request_id
     * @param $key
     * @return bool
     */
    public static function verify(string $request_id, $key = null)
    {
        if (empty($request_id)) {
            return false;
        }

        if (empty($key)) {
            $key = self::$key;
        }

        [$string, $sign, $timestamp] = array_pad(explode('.', $request_id), 3, null);

        $encrypt = md5($key . $string . $timestamp);

        if (empty($sign) || $encrypt != $sign) {
            return false;
        }

        return true;
    }
}