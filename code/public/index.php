<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use DudkinIv\TestPackage\App;

$app = new App();
echo $app->run();
