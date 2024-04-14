<?php

declare(strict_types=1);

use AlexanderPogorelov\Redis\App;

require dirname(__DIR__) . '/vendor/autoload.php';

try {
    $app = new App($argv);
    $app->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}
