<?php

declare(strict_types=1);

use AShutov\Hw17\App;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    print_r(App::run());
} catch (Throwable $e) {
    print_r($e->getMessage() . PHP_EOL);
}
