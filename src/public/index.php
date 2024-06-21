<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/constants.php';

use AlexanderGladkov\Demo\Application;

try {
    (new Application())->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
