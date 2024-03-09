#!/usr/local/bin/php
<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use AlexanderGladkov\SocketChat\Application\Application;

try {
    (new Application($argv))->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
