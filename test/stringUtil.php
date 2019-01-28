<?php

/*
 * This file is part of PHP CS Fixer.
 */

require_once '../StringUtil.php';

$uuid = StringUtil::uuid();
$string = 'abcdefg，欢迎你';
$subStr = StringUtil::mSubStr($string, 0, 15);

var_dump($uuid);
var_dump($subStr);
