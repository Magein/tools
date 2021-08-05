<?php

namespace magein\tools\common;

/**
 * 此类为了获取，不同服务平台返回的经纬度值可以通过此此类自动区分以及获取
 *
 * 仅适用中国地区
 *
 * Class Location
 * @package magein\php_tools\common
 */
class Location
{
    /**
     * 经度
     * @var string
     */
    private $longitude = '';

    /**
     * 纬度
     * @var string
     */
    private $latitude = '';

    /**
     * Location constructor.
     * @param null $location
     */
    public function __construct($location = null)
    {
        $this->parse($location);
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function toString()
    {
        if ($this->longitude && $this->latitude) {
            return $this->longitude . ',' . $this->latitude;
        }

        return '';
    }

    /**
     * @return array
     */
    public function toArray()
    {
        if ($this->longitude && $this->latitude) {
            return [
                $this->longitude,
                $this->latitude,
            ];
        }

        return [];
    }

    /**
     * 自动规整精度为的值
     *
     * 仅适用于国内的经纬度，
     *
     * 经度：0-180
     * 纬度：0-90
     * @param object|array|string $location
     */
    private function parse($location)
    {
        if (is_object($location)) {
            $location = json_decode($location, true);
        }

        if (!is_array($location)) {
            $location = explode(',', $location);
        }

        if (count($location) == 2) {
            $location = array_values($location);
            $longitude = $location[0];
            // 一般纬度在后
            $latitude = $location[1];
            // 纬度的范围是0-90，大于90的表示精度，
            if (0 < $latitude && $latitude <= 90) {
                $this->latitude = $latitude;
                $this->longitude = $longitude;
            } else {
                $this->latitude = $longitude;
                $this->longitude = $latitude;
            }
        }
    }
}