<?php

use KRudenko\Otus\Core\Kernel;

require __DIR__ . '/vendor/autoload.php';

$app = new Kernel();
echo $app->handleCommand();
