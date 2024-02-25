<?php

use Dotenv\Dotenv;
use hw5\services\MainService;

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../../';

// Composer
require($dirEnv . 'vendor/autoload.php');

try {
    $dotenv = Dotenv::createUnsafeImmutable($dirEnv);
    $dotenv->load();

    $method = $argv[1] ?? '';

    $mainservice = new \hw5\Creator();
    $mainservice->create($method)->process();

} catch (\Throwable $exception) {
    echo $exception->getMessage();
}
