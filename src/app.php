#!/usr/local/bin/php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AlexanderGladkov\Bookshop\Application\Application;

try {
    (new Application())->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
