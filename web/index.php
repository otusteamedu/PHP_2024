<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";
try {
    $dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "/..");
    $dotenv->load();
    $app = Main\App::getInstance();
    $app->run();
} catch (\Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}