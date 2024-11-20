<?php

declare(strict_types=1);

use Ahar\Hw11\Application;

require '../vendor/autoload.php';

try {
    $app = new Application();
    echo $app->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
