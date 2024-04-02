<?php

use Dotenv\Dotenv;

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../../';

// Composer
require($dirEnv . 'vendor/autoload.php');

$dotenv = Dotenv::createUnsafeImmutable($dirEnv);
$dotenv->load();

try {
    $storage = new \hw15\redis\Storage();
    echo (new \hw15\Creator($storage))->execute() . PHP_EOL;
} catch (\Throwable $e) {
    echo $e->getMessage();
}
