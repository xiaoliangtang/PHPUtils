<?php

/*
 * This file is part of PHP CS Fixer.
 */

class ImageUtil
{
    /**
     * 获取图像缩放宽高.
     *
     * @param string $image
     * @param int    $maxWidth
     * @param int    $maxHeight
     *
     * @return array
     */
    public static function getImageZoomWh($image, $maxWidth, $maxHeight)
    {
        //缩放图最大宽度与最大高度比
        $curScale = $maxWidth / $maxHeight;
        //原图宽和高
        list($width, $height) = getimagesize($image);
        //原图宽高比
        $scale = $width / $height;
        //图片缩放后的宽高
        if ($scale / $curScale >= 1) {//$scale > $curScale => $width > $maxWidth
            $width  = $maxWidth;
            $height = $maxWidth / $scale;
        } else {
            $width  = $maxHeight * $scale;
            $height = $maxHeight;
        }

        $ret = [
            'width'  => $width,
            'height' => $height,
        ];

        return $ret;
    }

    /**
     * 获取图像缩放宽高.
     *
     * @param string $image
     * @param int    $maxWidth
     * @param int    $maxHeight
     *
     * @return array
     */
    public static function getImageZoomWh2($image, $maxWidth, $maxHeight)
    {
        list($width, $height) = getimagesize($image);
        if ($width < $maxWidth && $height < $maxHeight) {
            $ret = [
                'width'  => $width,
                'height' => $height,
            ];

            return $ret;
        }

        //计算缩放比
        $scale = min($maxWidth / $width, $maxHeight / $height);
        $ret   = [
            'width'  => $width * $scale,
            'height' => $height * $scale,
        ];

        return $ret;
    }
}
