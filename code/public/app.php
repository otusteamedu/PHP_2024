<?php

declare(strict_types=1);

use Irayu\Hw13;

require_once __DIR__ . '/../vendor/autoload.php';

(new Hw13\App(
    [
        'host' => $_ENV['MYSQL_HOST'],
        'port' => $_ENV['MYSQL_PORT'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'db_name' => $_ENV['MYSQL_DATABASE'],
    ]
))->run(...array_slice($argv, 1));
