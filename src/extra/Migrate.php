<?php

namespace magein\tools\extra;

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\db\Table;

/**
 * 添加create_time、update_time、delete_time字段信息
 * Class MigrateLogic
 * @package app\common\core\logic\extra
 */
class Migrate
{

    /**
     *  追加状态
     */
    const APPEND_STATUS = 'status';

    /**
     * 追加排序
     */
    const APPEND_SORT = 'sort';

    /**
     * 追加开始时间
     */
    const APPEND_START_TIME = 'start_time';

    /**
     * 追加结束时间
     */
    const APPEND_END_TIME = 'end_time';

    /**
     * 追加标题
     */
    const APPEND_TITLE = 'title';

    private static $append = [];

    /**
     * @param array $append
     */
    public static function setAppend(array $append = ['status', 'sort'])
    {
        self::$append = $append;
    }

    /**
     * 直接创建表
     * @param $table
     * @param array $columns
     * @param array $index 如果是一个字符串,则表示给字符串添加普通索引,如果是数组,则键是字段名称,值是选项
     */
    public static function create($table, $columns = [], $index = [])
    {
        self::get($table, $columns, $index)->create();
    }

    /**
     * 获取表，可以添加索引，等
     *
     * 添加普通索引
     *  $index='phone';
     * 添加唯一索引
     *  $index=[
     *     'phone'=>['unique'=>true]
     *  ];
     *
     * @param Table $table
     * @param array $columns
     * @param string|array $index 如果是一个字符串,则表示给字符串添加普通索引,如果是数组,则键是字段名称,值是选项
     * @return Table
     */
    public static function get($table, $columns = [], $index = null)
    {
        if ($columns) {
            foreach ($columns as $column) {
                if (isset($column[2])) {
                    $table->addColumn($column[0], $column[1], $column[2]);
                } else {
                    $table->addColumn($column[0], $column[1]);
                }
            }
        }

        if (self::$append && is_array(self::$append)) {
            foreach (self::$append as $item) {
                switch ($item) {
                    case self::APPEND_TITLE:
                        $table->addColumn($item, 'integer', ['limit' => MysqlAdapter::INT_TINY, 'comment' => '排序', 'default' => 99]);
                        break;
                    case self::APPEND_START_TIME:
                        $table->addColumn($item, 'integer', ['comment' => '开始时间', 'default' => 0]);
                        break;
                    case self::APPEND_END_TIME:
                        $table->addColumn($item, 'integer', ['comment' => '结束时间', 'default' => 0]);
                        break;

                    case self::APPEND_STATUS:
                        $table->addColumn($item, 'integer', ['limit' => MysqlAdapter::INT_TINY, 'comment' => '状态 0 禁用 forbid 1 启用 open', 'default' => 1]);
                        break;
                    case self::APPEND_SORT:
                        $table->addColumn($item, 'integer', ['limit' => MysqlAdapter::INT_TINY, 'comment' => '排序', 'default' => 99]);
                        break;

                }
            }
        }

        $table->addColumn('create_time', 'integer', ['comment' => '创建时间'])
            ->addColumn('update_time', 'integer', ['comment' => '更新时间'])
            ->addColumn('delete_time', 'integer', ['comment' => '删除时间', 'default' => null, 'null' => true]);

        if ($index) {
            if (is_string($index)) {
                $table->addIndex($index);
            } elseif (is_array($index)) {
                foreach ($index as $key => $item) {
                    $table->addIndex($key, $item);
                }
            }
        }

        // 获取后，清除追加的元素，方式对后续的表格照成影响
        self::setAppend([]);

        return $table;
    }
}