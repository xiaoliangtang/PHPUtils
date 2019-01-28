<?php

/*
 * This file is part of PHP CS Fixer.
 */

class ArchiveUtil
{
    const DIRECTORY_SEPARATOR = '/';
    private $zip              = null;

    public function __construct()
    {
        $this->zip = new ZipArchive();
    }

    /**
     * 压缩文件夹.
     *
     * @param string $zipFile 压缩文件（需完整路径）
     * @param string $dir     待压缩目录（需完整路径）
     *
     * @return bool
     */
    public function compress($zipFile, $dir)
    {
        // 生成压缩包文件
        if (!(true === $this->zip->open($zipFile, ZipArchive::CREATE))) {
            return false;
        }

        // 依次添加文件到压缩包
        $this->addFileToZip($dir);

        // 关闭
        return $this->zip->close();
    }

    /**
     * 解压缩文件.
     *
     * @param string $zipFile 待解压的压缩文件
     * @param string $dir     解压的目标目录
     *
     * @return bool
     */
    public function deCompress($zipFile, $dir)
    {
        if (true === $this->zip->open($zipFile)) {
            $this->zip->extractTo($dir);

            return $this->zip->close();
        }
    }

    /**
     * 添加压缩文件（不支持中文文件名）.
     *
     * @param string $dir
     */
    private function addFileToZip($dir)
    {
        // 打开目录句柄
        $handler = opendir($dir);
        while (false !== ($filename = readdir($handler))) {
            if ('.' != $filename && '..' != $filename) {// 文件夹文件名字为'.'和'..'，不要对他们进行操作
                $filePath = $dir . self::DIRECTORY_SEPARATOR . $filename;
                if (is_dir($filePath)) {// 如果读取的某个对象是文件夹，则递归
                    self::addFileToZip($filePath);
                } else {
                    // 将文件依次加入zip对象
                    $this->zip->addFile($filePath);
                }
            }
        }
    }
}
