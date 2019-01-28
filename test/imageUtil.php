<?php

/*
 * This file is part of PHP CS Fixer.
 */

require_once '../ImageUtil.php';

$ret = ImageUtil::getImageZoomWh2('./files/images/test.jpg', 500, 700);
var_dump($ret);
