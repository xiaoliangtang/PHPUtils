<?php

/*
 * This file is part of PHP CS Fixer.
 */

include_once '../ArchiveUtil.php';

$compress = new ArchiveUtil();
$file     = './files/zip.zip';
//$res      = $compress->compress($file, './files');
$res = $compress->deCompress($file, './files/deCompressFile');
var_dump($res);
