<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AShutov\Hw15\App;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $app = new App();
    $message = $app->run();
    print_r($message . PHP_EOL);
} catch (Throwable $e) {
    print_r($e->getMessage() . PHP_EOL);
}
