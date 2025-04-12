<?php

declare(strict_types=1);

use Asyrovatkin\Hw14\App;

require __DIR__ . '/vendor/autoload.php';

$app = new App();

echo $app->run();