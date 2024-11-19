<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AnatolyShilyaev\MyComposerPackage\Summ\Summ;
use AnatolyShilyaev\MyComposerPackage\Subtract\Subtract;

$summ = new Summ();
echo $summ->getSumm(2, 5) . PHP_EOL;

$subtract = new Subtract();
echo $subtract->getSubtract(15, 2) . PHP_EOL;
