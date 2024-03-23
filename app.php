<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

try {
    $dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    $dotenv->load();
    $app = Main\App::getInstance();
    $appIterator = $app->run($argv);
    if($appIterator instanceof \Generator) {
        foreach ($appIterator as $message){
            echo $message;
        }
    }
} catch (\Throwable $e) {

    echo $e->getMessage() . PHP_EOL;
}
