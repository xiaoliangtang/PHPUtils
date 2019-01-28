<?php

/*
 * This file is part of PHP CS Fixer.
 */

class FileUtil
{
    /**
     * 循环创建目录.
     *
     * @param string $path
     * @param int    $mode
     * @param bool   $recursive
     *
     * @return bool
     */
    public static function createDir($path, $mode = 0777, $recursive = true)
    {
        if (!is_dir($path)) {
            return mkdir($path, $mode, $recursive);
        }
    }

    /**
     * 删除目录.
     *
     * @param string $dirName
     *
     * @return bool
     */
    public static function deleteDir($dirName)
    {
        if (!is_dir($dirName)) {
            return false;
        }
        $handle = @opendir($dirName);
        while (false !== ($file = @readdir($handle))) {
            if ('.' != $file && '..' != $file) {
                $dir = $dirName . '/' . $file;
                is_dir($dir) ? self::deleteDir($dir) : @unlink($dir);
            }
        }
        closedir($handle);

        return rmdir($dirName);
    }

    /**
     * 写文件操作.
     *
     * @param string $fileName
     * @param string $content
     * @param string $mode
     *
     * @return bool
     */
    public static function writeFile($fileName, $content, $mode = 'w')
    {
        if (@$fp = fopen($fileName, $mode)) {
            flock($fp, 2);
            fwrite($fp, $content);
            fclose($fp);

            return true;
        }

        return false;
    }

    /**
     * 删除文件.
     *
     * @param string $file
     *
     * @return bool
     */
    public static function deleteFile($file)
    {
        if (file_exists($file)) {
            return unlink($file);
        }

        return false;
    }

    /**
     * 取得文件路径信息.
     *
     * @param string $file
     *
     * @return ArrayObject
     */
    public static function getPathInfo($file)
    {
        return pathinfo($file);
    }

    /**
     * 获取指定文件和目录的信息.
     *
     * @param string $file
     *
     * @return array
     */
    public static function getFileOrDirInfo($file)
    {
        $info               = [];
        $info['filename']   = basename($file); //返回路径中的文件名部分。
        $info['pathname']   = realpath($file); //返回绝对路径名。
        $info['owner']      = fileowner($file); //文件的 user ID （所有者）。
        $info['perms']      = fileperms($file); //返回文件的 inode 编号。
        $info['iNode']      = fileinode($file); //返回文件的 inode 编号。
        $info['group']      = filegroup($file); //返回文件的组 ID。
        $info['path']       = dirname($file); //返回路径中的目录名称部分。
        $info['aTime']      = fileatime($file); //返回文件的上次访问时间。
        $info['cTime']      = filectime($file); //返回文件的上次改变时间。
        $info['perms']      = fileperms($file); //返回文件的权限。
        $info['size']       = filesize($file); //返回文件大小。
        $info['type']       = filetype($file); //返回文件类型。
        $info['ext']        = is_file($file) ? pathinfo($file, PATHINFO_EXTENSION) : ''; //返回文件后缀名
        $info['mTime']      = filemtime($file); //返回文件的上次修改时间。
        $info['isDir']      = is_dir($file); //判断指定的文件名是否是一个目录。
        $info['isFile']     = is_file($file); //判断指定文件是否为常规的文件。
        $info['isLink']     = is_link($file); //判断指定的文件是否是连接。
        $info['isReadable'] = is_readable($file); //判断文件是否可读。
        $info['isWritable'] = is_writable($file); //判断文件是否可写。
        $info['isUpload']   = is_uploaded_file($file); //判断文件是否是通过 HTTP POST 上传的。
        return $info;
    }

    /**
     * 获取文件后缀名.
     *
     * @param string $file 文件路径
     *
     * @return string
     */
    public static function getFileExt($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
     * 获取服务器最大上传限制（字节数）.
     *
     * @return int
     */
    public static function getAllowUploadSize()
    {
        return ini_get('upload_max_filesize');
    }

    /**
     * 判断目录是否为空.
     *
     * @param string $dir
     *
     * @return bool
     */
    public static function isDirEmpty($dir)
    {
        $handle = opendir($dir);
        while (false !== ($file = readdir($handle))) {
            if ('.' != $file && '..' != $file) {
                closedir($handle);

                return false;
            }
        }
        closedir($handle);

        return true;
    }

    /**
     * 字节格式化（把字节数格式为 B K M G T P E Z Y 描述的大小）.
     *
     * @param int $size 大小
     * @param int $dec  显示类型
     *
     * @return int
     */
    public static function byteFormat($size, $dec = 2)
    {
        $type = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $pos  = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }

        return round($size, $dec) . ' ' . $type[$pos];
    }

    /**
     * 复制目录.
     *
     * @param string $sourceDir 原目录
     * @param string $toDir     目标目录
     *
     * @return bool
     */
    public static function copyDir($sourceDir, $toDir)
    {
        $sourceDir = rtrim($sourceDir, '/') . '/';
        $toDir     = rtrim($toDir, '/') . '/';
        if (!file_exists($sourceDir)) {
            return  false;
        }

        if (!file_exists($toDir)) {
            mkdir($toDir, 0777, true);
        }
        $handle = opendir($sourceDir);
        while (false !== ($file = readdir($handle))) {
            $sourceFile = $sourceDir . '/' . $file;
            $toFile     = $toDir . '/' . $file;
            if ('.' != $file && '..' != $file) {
                if (is_dir($sourceFile)) {
                    self::copyDir($sourceFile, $toFile);
                } else {
                    copy($sourceFile, $toFile);
                }
            }
        }
        closedir($handle);

        return true;
    }

    /**
     * 非递归实现查询该目录下所有文件（非递归）.
     *
     * @param string $dir
     *
     * @return array
     */
    public static function scanDir($dir)
    {
        if (!is_dir($dir)) {
            return [];
        }
        //兼容各操作系统
        $dir = rtrim(str_replace('\\', '/', $dir), '/') . '/';
        //栈，默认值为传入的目录
        $dirs = [$dir];
        //放置所有文件的容器
        $fileContainer = [];
        do {
            // 弹栈
            $dir = array_pop($dirs);
            //扫描该目录
            $tmp = scandir($dir);
            foreach ($tmp as $f) {
                if ('.' == $f || '..' == $f) {
                    continue;
                }
                //组合当前绝对路径
                $path = $dir . $f;
                //如果是目录，压栈。
                if (is_dir($path)) {
                    array_push($dirs, $path . '/');
                } elseif (is_file($path)) { //如果是文件，放入容器中
                    $path            = iconv('gb2312', 'utf-8', $path); //处理中文文件名乱码
                    $fileContainer[] = $path;
                }
            }
        } while ($dirs); //直到栈中没有目录

        return $fileContainer;
    }

    /**
     * 遍历某个目录下的所有文件（递归实现）.
     *
     * @param string $dir
     *
     * @return array
     */
    public static function scanDirByRecursive($dir)
    {
        if (!is_dir($dir)) {
            return [];
        }
        //兼容各操作系统
        $dir           = rtrim(str_replace('\\', '/', $dir), '/') . '/';
        $fileContainer = [];
        $children      = scandir($dir);
        foreach ($children as $child) {
            if ('.' == $child || '..' == $child) {
                continue;
            }
            $path = $dir . $child;
            if (is_file($path)) {
                $path            = iconv('gb2312', 'utf-8', $path); //处理中文文件名乱码
                $fileContainer[] = $path;
            } elseif (is_dir($path)) {
                //递归合并
                $fileContainer = array_merge($fileContainer, self::scanDirByRecursive($path));
            }
        }

        return $fileContainer;
    }

    /**
     * 遍历某个目录下的所有文件（递归实现）.
     *
     * @param string $dir
     *
     * @return array
     */
    public static function scanDirByRecursive2($dir)
    {
        $files = [];
        if (@$handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                if ('..' != $file && '.' != $file) { //排除根目录
                    $file = iconv('gb2312', 'utf-8', $file); //处理中文文件名乱码
                    if (is_dir($dir . '/' . $file)) { //如果是子文件夹，就进行递归
                        $files[$file] = self::scanDirByRecursive2($dir . '/' . $file);
                    } else { //不然就将文件的名字存入数组
                        $files[] = $file;
                    }
                }
            }
            closedir($handle);

            return $files;
        }
    }

    /**
     * 下载文件.
     *
     * @param string $url
     * @param string $desDir
     * @param string $desFile
     * @param mixed  $size
     *
     * @return bool
     */
    public static function downLoadFile($url, $desDir = '', $desFile = '', $size = 1024 * 8)
    {
        if (!$desFile) {
            $desFile = basename($url);
        }
        $desFile    = $desDir . $desFile;
        $remoteFile = fopen($url, 'rb');
        if ($remoteFile) {
            $targetFile = fopen($desFile, 'wb');
            if ($targetFile) {
                while (!feof($remoteFile)) {
                    fwrite($targetFile, fread($remoteFile, $size), $size);
                }
            }
            $remoteFile && fclose($remoteFile);
            $targetFile && fclose($targetFile);

            return true;
        }

        return false;
    }
}
