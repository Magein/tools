<?php
/**
 * Created by PhpStorm.
 * User: xiaomage
 * Date: 2021/1/13
 * Time: 10:35
 */

namespace magein\tools\common;


class RegVerify
{
    /**
     * 验证手机
     * @param $number
     * @return bool
     */
    public static function phone($number)
    {
        if (!preg_match("/^13[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|16[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|19[0-9]{1}[0-9]{8}$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function email($email)
    {
        if (!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $email)) {
            return false;
        }
        return true;
    }

    /**
     * @param $number
     * @return bool
     */
    public static function qq($number)
    {
        if (!preg_match("/^[1-9]\d{4,}$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param $number
     * @return bool
     */
    public static function idCard($number)
    {
        if (!preg_match("/^\d{6}(19|20)\d{2}([0][1-9]|11|12)([0,1,2][1-9]|[3][0,1])\d{3}([0-9]|X|x)$/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * url地址
     * @param $number
     * @return bool
     */
    public static function url($number)
    {
        if (!preg_match("/[a-zA-z]+:\/\/[^\s]*/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * @param $number
     * @return bool
     */
    public static function ip($number)
    {
        if (!preg_match("/((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?)/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * 数字字母下划线
     * @param $number
     * @return bool
     */
    public static function password($number)
    {
        if (!preg_match("/[\w]{6,18}/", $number)) {
            return false;
        }
        return true;
    }

    /**
     * 传递的是一个url 则自动获取格式，如果传递的是格式，则直接验证
     * @param $url
     * @return bool
     */
    public static function image($url)
    {
        if (self::url($url)) {
            $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        } else {
            $ext = $url;
        }

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            return true;
        }

        return false;
    }
}