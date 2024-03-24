<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Tory495\Elasticsearch\App;

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $app = new App();
    $app->run();
} catch (InvalidPathException $e) {
    echo $e->getMessage() . PHP_EOL;
}
