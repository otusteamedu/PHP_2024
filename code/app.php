<?php

require_once __DIR__ . '/vendor/autoload.php';

use AgapitovAlexandr\OtusHomework\App;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    (new App())->run();
} catch (Exception $exception) {
    var_dump($exception->getMessage());
}