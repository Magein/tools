<?php
/**
 * Created by PhpStorm.
 * User: xiaomage
 * Date: 2021/1/11
 * Time: 13:39
 */

namespace magein\tools\common;


class RemoteImage
{
    /**
     * @var string
     */
    private $url = '';

    /**
     * @var string
     */
    private $save_name = '';

    /**
     * @var string
     */
    private $ext = '';

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var bool
     */
    private $isWrite = false;

    /**
     * RemoteImage constructor.
     * @param $url
     * @param string $save_name
     * @param string $ext
     */
    public function __construct($url, $save_name = '', $ext = '')
    {
        $this->url = trim($url);
        $this->save_name = $save_name;
        $this->ext = $ext;
        $this->pull();
    }

    /**
     * @param $message
     */
    private function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isWrite()
    {
        return $this->isWrite;
    }

    /**
     * @return bool
     */
    private function pull()
    {
        if (empty($this->url)) {
            $this->setMessage('请输入远程图片地址');
            return false;
        }

        if (empty($this->save_name)) {
            $this->setMessage('请输入保存图片路径');
            return false;
        }

        $save_name = pathinfo($this->save_name);

        $save_dir = $save_name['dirname'];
        $filename = $save_name['filename'];
        $ext = $save_name['extension'] ?? '';

        if ($ext) {
            $this->ext = $ext;
        }

        if (empty($this->ext)) {
            $ext = strtolower(pathinfo($this->url, PATHINFO_EXTENSION));
            $this->ext = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']) ?: 'png';
        }

        // 保存路径
        $path = $save_dir . '/' . $filename . '.' . $this->ext;

        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            $this->setMessage('图片保存路径创建失败');
            return false;
        }

        //获取远程文件所采用的方法
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $img = curl_exec($ch);
        curl_close($ch);
        $fp2 = @fopen($path, 'a');
        fwrite($fp2, $img);
        fclose($fp2);
        unset($img, $url);

        if (is_file($path)) {
            return $this->isWrite = true;
        }

        $this->setMessage('图片下载失败');
        return $this->isWrite = false;
    }
}