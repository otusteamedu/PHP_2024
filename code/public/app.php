<?php

declare(strict_types=1);

use Irayu\Hw13;

(new Hw13\App(
    [
        'host' => $_ENV['MYSQL_HOST'],
        'port' => $_ENV['MYSQL_PORT'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'db_name' => $_ENV['MYSQL_DB'],
    ]
))->run();
