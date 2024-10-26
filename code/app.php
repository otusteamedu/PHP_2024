<?php

use Core\App;

require_once 'auto.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    (new App())->run();
} catch (Exception $exception) {
    var_dump($exception->getMessage());
}