<?php

require __DIR__ . '/../vendor/autoload.php';

use KRudenko\Otus\Core\App;

$app = new App();
echo $app->run();
