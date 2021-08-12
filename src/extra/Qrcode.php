<?php


namespace magein\tools\extra;

use Endroid\QrCode\QrCode as QrcodeLib;

/**
 *
 * 依赖 Endroid\QrCode\QrCode:3.0版本
 *
 * composer require  Endroid\QrCode\QrCode:3.0 -vvv -o --prefer-dist
 *
 * Class Qrcode
 * @package app\common
 */
class Qrcode
{
    /**
     * @param string $text
     */
    public function output(string $text = '')
    {
        if (empty($text)) {
            $text = request()->domain();
        }
        $qrCode = new QrcodeLib($text);
        header('Content-Type: ' . $qrCode->getContentType());
        echo $qrCode->writeString();
        exit();
    }

    /**
     * 保存二维码
     * @param string $text
     * @param string $save_name
     */
    public function save($text = '', string $save_name = '')
    {
        if (empty($text)) {
            $text = request()->domain();
        }

        if (empty($save_name)) {
            $save_name = '/storage/qrcode/' . date('Ymd') . '/' . date('YmdHi') . rand(1000, 9999) . '.png';
        }

        $qrCode = new QrcodeLib($text);
        $qrCode->setSize(200);
        $qrCode->setMargin(10);
        $qrCode->writeFile($save_name);
    }

    /**
     * 生成base64
     * @param $text
     * @return string
     */
    public function base64($text = '')
    {
        if (empty($text)) {
            $text = request()->domain();
        }

        $qrCode = new QrcodeLib($text);

        return $qrCode->writeDataUri();
    }
}