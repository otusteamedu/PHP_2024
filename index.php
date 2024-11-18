<?php

declare(strict_types=1);

use SergeyShirykalov\HashCalculator\HashCalculator;

require_once 'vendor/autoload.php';

$calculator = new HashCalculator();
echo $calculator->md5('test string') . PHP_EOL;
