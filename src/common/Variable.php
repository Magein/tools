<?php

namespace magein\tools\common;

/**
 * 驼峰，帕斯卡，下划线命名转化
 * Class Variable
 * @package Tools
 */
class Variable
{
    /**
     * @var null|static 实例对象
     */
    protected static $instance = null;

    /**
     * 获取示例
     * @return static
     */
    public static function instance()
    {
        if (is_null(self::$instance)) self::$instance = new self();

        return self::$instance;
    }

    /**
     * 下划线命名转化为驼峰命名
     * @param string $variable
     * @return string|string[]|null
     */
    public function camelCase(string $variable)
    {
        if (empty($variable)) {
            return $variable;
        }
        $variable = trim($variable, '_');
        $variable = preg_replace_callback('/_([a-z])/', function ($matches) {
            return ucfirst(isset($matches[1]) ? $matches[1] : '');
        }, $variable);

        return lcfirst($variable);
    }

    /**
     * 下划线命名(含驼峰)转化为帕斯卡命名法（驼峰命名法的首字母大写）
     * @param string $variable
     * @return mixed|string
     */
    public function pascal(string $variable)
    {
        if (empty($variable)) {
            return $variable;
        }
        $variable = trim($variable, '_');
        $variable = preg_replace_callback('/_([a-z])/', function ($matches) {
            return ucfirst(isset($matches[1]) ? $matches[1] : '');
        }, $variable);

        return ucfirst($variable);
    }

    /**
     * 驼峰转命名(含帕卡斯)转化为下划线命名
     * @param string $variable
     * @return mixed|string
     */
    public function underline(string $variable)
    {
        if (empty($variable)) {
            return $variable;
        }
        $variable = trim($variable, '_');
        $variable = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . lcfirst(isset($matches[1]) ? $matches[1] : '');
        }, $variable);

        return trim($variable, '_');
    }
}