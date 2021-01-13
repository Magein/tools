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
     * @return int|string
     */
    public static function make()
    {
        $string = RandomString::make(12);
        $timestamp = time();
        $sign = self::$key . $string . $timestamp;
        return $string . '.' . md5($sign) . '.' . time();
    }

    /**
     * @param string|null $request_id
     * @return bool
     */
    public static function verify(string $request_id)
    {
        if (empty($request_id)) {
            return false;
        }

        [$string, $sign, $timestamp] = array_pad(explode('.', $request_id), 3, null);

        $encrypt = md5(self::$key . $string . $timestamp);

        if (empty($sign) || $encrypt != $sign) {
            return false;
        }

        return true;
    }
}