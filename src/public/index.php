<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AlexanderGladkov\EmailValidation\Application;

try {
    (new Application())->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
