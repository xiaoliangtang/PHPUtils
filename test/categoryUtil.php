<?php

/*
 * This file is part of PHP CS Fixer.
 */

include_once '../CategoryUtil.php';

$cate = [
    [
        'id'       => 3,
        'parentId' => 2,
        'name'     => 'php',
    ],
    [
        'id'       => 2,
        'parentId' => 0,
        'name'     => '博客',
    ],
    [
        'id'       => 1,
        'parentId' => 0,
        'name'     => '首页',
    ],
    [
        'id'       => 4,
        'parentId' => 2,
        'name'     => 'java',
    ],
    [
        'id'       => 5,
        'parentId' => 3,
        'name'     => '文件操作',
    ],
    [
        'id'       => 6,
        'parentId' => 3,
        'name'     => 'Socket通信',
    ],
];

$arr     = CategoryUtil::unlimitedForLayer($cate);
$parents = CategoryUtil::getParents($cate, 5);
$childs  = CategoryUtil::getChilds($cate, 2);

echo '<pre>';
//print_r($arr);
//print_r($parents);
print_r($childs);
