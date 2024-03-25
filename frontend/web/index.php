<?php

use Dotenv\Dotenv;

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../../';

// Composer
require($dirEnv . 'vendor/autoload.php');

$dotenv = Dotenv::createUnsafeImmutable($dirEnv);
$dotenv->load();

try {
    $method = (new \hw14\Bootstrap())->getMethod();
    echo (new \hw14\Creator())->create($method);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
