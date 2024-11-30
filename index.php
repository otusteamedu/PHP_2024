<?php

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

use bulgar989\PhpComposerOtus\Summ;
use bulgar989\PhpComposerOtus\Subtract;

$summ = new Summ();
echo $summ->getSumm(5, 2); // 7

$subtract = new Subtract();
echo $subtract->getSubtract(5, 2); // 3