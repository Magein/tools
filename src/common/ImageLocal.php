<?php
/**
 * Created by PhpStorm.
 * User: xiaomage
 * Date: 2021/1/11
 * Time: 13:39
 */

namespace magein\tools\common;

class ImageLocal
{
    /**
     * @param $content
     * @param $save_name
     * @param string $ext
     * @return bool
     */
    public function base64($content, $save_name, $ext = '')
    {
        if (empty($content)) {
            MsgDeliver::message('图片内容为空');
            return false;
        }

        if (empty($save_name)) {
            MsgDeliver::message('请输入保存图片路径');
            return false;
        }

        $save_name = pathinfo($save_name);
        $save_dir = $save_name['dirname'];
        $filename = $save_name['filename'];
        $file_ext = $save_name['extension'] ?? '';

        if (empty($ext)) {
            $ext = $file_ext ?: 'png';
        }

        // 保存路径
        $path = $save_dir . '/' . $filename . '.' . $ext;

        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            MsgDeliver::message('图片保存路径创建失败');
            return false;
        }

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $content, $result)) {
            file_put_contents($path, base64_decode(str_replace($result[1], '', $content)));
        }

        if (is_file($path)) {
            return true;
        }

        MsgDeliver::message('图片保存失败');
        return false;
    }

    /**
     * @param $url
     * @param $save_name
     * @param string $ext 保存的文件格式，传递的话优先使用
     * @return bool
     */
    public function pull($url, $save_name, $ext = '')
    {
        if (empty($url)) {
            MsgDeliver::message('请输入远程图片地址');
            return false;
        }

        if (empty($save_name)) {
            MsgDeliver::message('请输入保存图片路径');
            return false;
        }

        $save_name = pathinfo($save_name);

        $save_dir = $save_name['dirname'];
        $filename = $save_name['filename'];
        $file_ext = $save_name['extension'] ?? '';
        $origin_ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));

        if (empty($ext)) {
            $ext = $file_ext ?: $origin_ext;
        }

        // 保存路径
        $path = $save_dir . '/' . $filename . '.' . ($ext ?: 'png');

        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            MsgDeliver::message('图片保存路径创建失败');
            return false;
        }

        //获取远程文件所采用的方法
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $img = curl_exec($ch);
        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);
        if (!preg_match('/image/', $mime)) {
            MsgDeliver::message('图片远程地址异常');
            return false;
        }

        $fp2 = @fopen($path, 'a');
        fwrite($fp2, $img);
        fclose($fp2);
        unset($img, $url);

        if (is_file($path)) {
            return true;
        }

        MsgDeliver::message('图片下载失败');
        return false;
    }
}