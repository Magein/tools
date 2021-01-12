<?php

namespace magein\tools\common;

/**
 * 导出csv
 * Class CsvLogic
 * @package app\common\core\logic\extra
 */
class Csv
{
    /**
     * 表格的头部信息
     * @var array
     */
    private $header = [];

    /**
     * 表格的数据
     * @var array
     */
    private $data = [];

    /**
     * Csv constructor.
     * @param array $header
     * @param array $data
     */
    public function __construct(array $header = [], array $data = [])
    {
        $this->setHeader($header);
        $this->setData($data);
    }

    /**
     * @param $header
     */
    public function setHeader(array $header)
    {
        $this->header = $header;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * 校正表头跟数据主体的位置信息
     * @return array|bool
     */
    public function correcting()
    {
        $result = [];

        foreach ($this->data as $datum) {
            $temp = [];
            foreach ($this->header as $key => $item) {
                if (isset($datum[$key])) {
                    $temp[] = $datum[$key];
                }
            }
            $result[] = $temp;
        }

        return $result;
    }

    /**
     * 获取导出的文件名称
     * @param null $fileName
     * @return null|string
     */
    private function getFileName($fileName = null)
    {
        if (empty($fileName)) {
            $fileName = date('YmdHi') . rand(1000, 9999);
        }

        if (!preg_match('/.csv/', $fileName)) {
            $fileName .= '.csv';
        }

        return $fileName;
    }


    /**
     * 设置头部信息
     * @param $fileName
     */
    private function header($fileName)
    {
        header('Content-Type: text/csv; charset=utf-8');
        if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
            header('Content-Disposition:  attachment; filename="' . $fileName . '"');
        } else {
            if (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {
                header('Content-Disposition: attachment; filename*="utf8' . $fileName . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
            }
        }
    }

    /**
     * 拼接头部信息和表格数据
     * @return string
     */
    public function concat()
    {
        $string = '';

        if ($this->header) {
            $header = implode(',', $this->header);
            $string = $header . "\n";
        }

        $data = $this->correcting();

        foreach ($data as $item) {
            if (is_array($item)) {
                $tmp = '';
                foreach ($item as $val) {
                    $tmp .= '"' . preg_replace('/(["])/', '"$1', $val) . '"' . ',';
                }
                $string .= trim($tmp, ',') . "\n";
            }
        }

        return $string;
    }

    /**
     * 从指定文件中读取并下载到浏览器
     * @param $filepath
     * @param $filename
     * @return bool
     */
    public function readFile($filepath, $filename = '')
    {
        if (!is_file($filepath)) {
            return false;
        }

        if (empty($filename)) {
            $filename = date('YmdHis');
        }

        $content = file_get_contents($filepath);

        $this->header($filename);
        echo "\xEF\xBB\xBF" . $content;
        exit();
    }

    /**
     * @param $filename
     */
    public function export($filename)
    {
        $content = $this->concat();
        $filename = $this->getFileName($filename);
        $this->header($filename);
        echo "\xEF\xBB\xBF" . $content;
        exit();
    }

    /**
     * 保存到指定位置
     * @param string $filename
     * @return bool|string|null
     */
    public function save($filename = '')
    {
        $string = $this->concat();

        $fileName = $this->getFileName($filename);

        $path = pathinfo($filename, PATHINFO_DIRNAME);

        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                return false;
            }
        }

        if (is_file($filename)) {
            return $filename;
        }

        $string = "\xEF\xBB\xBF" . $string;

        $result = file_put_contents($filename, $string);

        if ($result) {
            return $fileName;
        }

        return false;
    }
}