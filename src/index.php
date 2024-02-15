<?php

declare(strict_types=1);

use Ahor\Hw3\Calculate;

require __DIR__ . '/../vendor/autoload.php';

$calculate = new Calculate();
echo $calculate->addInt(3, 5);
