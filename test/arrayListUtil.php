<?php

/*
 * This file is part of PHP CS Fixer.
 */

require_once '../ArrayListUtil.php';

$list = new ArrayList([1, 2, 3]);

$list->add(1);
$iterator = $list->getIterator();
$size     = $list->size();
$json     = $list->toJson();

var_dump($iterator, $size, $json);
