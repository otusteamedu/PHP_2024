<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\App;

$app = new App();
echo $app->run();