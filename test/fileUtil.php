<?php

/*
 * This file is part of PHP CS Fixer.
 */

include_once '../FileUtil.php';

$res = FileUtil::createDir('./files/wordFiles');

$ext = FileUtil::getFileExt('./files/excel.xls');

$pathInfo = FileUtil::getPathInfo('./files/excel.xls');

$isDirEmpty = FileUtil::isDirEmpty('./files');

$info = FileUtil::getFileOrDirInfo('./files/excel.xls');

$maxSize = FileUtil::getAllowUploadSize();

$fileSize = FileUtil::byteFormat(filesize('./files/excel.xls'));

var_dump($res);
var_dump($ext);
var_dump($pathInfo);
var_dump($isDirEmpty);
var_dump($info);
var_dump($maxSize);
var_dump($fileSize);
