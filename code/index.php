<?php

declare(strict_types=1);

use ASyrovatkin\Hw5\App;

require __DIR__ . '/vendor/autoload.php';

$app = new App();
print $app->run();
