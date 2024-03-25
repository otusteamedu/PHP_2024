<?php

use Dotenv\Dotenv;

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../../';

// Composer
require($dirEnv . 'vendor/autoload.php');

$dotenv = Dotenv::createUnsafeImmutable($dirEnv);
$dotenv->load();

try {
    echo (new \hw14\Creator())->run() . PHP_EOL;
} catch (\Throwable $e) {
    echo $e->getMessage();
}
