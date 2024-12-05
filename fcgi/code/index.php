<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Otus\App\Application;

$app = new Application();
echo $app->run();
