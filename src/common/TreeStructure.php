<?php

namespace magein\php_tools\common;


/**
 * 数组处理成树结构
 * Class TreeStructure
 * @package magein\php_tools\common
 */
class TreeStructure
{
    /**
     * 传递的原始数据
     * @var array
     */
    private $origin = [];

    /**
     * 关联字段
     * @var string
     */
    private $relation_field = 'pid';

    /**
     * 主键
     * @var string
     */
    private $primary_id = '';

    /**
     * TreeStructure constructor.
     * @param array $data
     * @param string $relation_field
     * @param string $primary_id
     */
    public function __construct(array $data, $relation_field = 'pid', $primary_id = 'id')
    {
        $this->origin = $data;

        $this->relation_field = $relation_field ?: $this->relation_field;

        $this->primary_id = $primary_id;
    }

    /**
     * 获取数据结构
     * @param null $callback
     * @return array
     */
    public function tree($callback = null)
    {
        if (empty($this->origin)) {
            return [];
        }

        $relation_field = $this->relation_field;
        $primary_id = $this->primary_id;

        $data = [];
        foreach ($this->origin as $item) {
            $data[$item[$primary_id]] = $item;
        }

        $result = [];

        foreach ($data as $key => $item) {
            if (is_callable($callback)) {
                $item = call_user_func($callback, $item, $result);
            }
            if (isset($data[$item[$relation_field]])) {
                $data[$item[$relation_field]]['children'][] = &$data[$key];
            } else {
                $result[] = &$data[$key];
            }
        }

        return $result;
    }
}