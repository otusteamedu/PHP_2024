<?php

declare(strict_types=1);

/*
echo PHP_EOL . json_encode([
    'priority' => 1,
    'name' => 'First player',
    'properties' => [
        'game' => 'Baseball',
        'team' => 'Yankees',
    ]
    ]) . PHP_EOL;
exit;*/

require '../vendor/autoload.php';

$ini = parse_ini_file('./app.ini');
use IraYu\Hw12;
(new Hw12\App(
    $ini['db_type'],
    ($ini['db_type'] === 'redis' ?
        [
            'host' => $_ENV['REDIS_HOST'],
            'port' => $_ENV['REDIS_PORT'],
            'user' => $_ENV['REDIS_USER'],
            'password' => $_ENV['REDIS_PASSWORD'],
            'db_name' => $ini['redis_db_name'],
        ] : [
            'host' => $_ENV['ES_HOST'],
            'port' => $_ENV['ES_PORT'],
            'user' => $_ENV['ES_USER'],
            'password' => $_ENV['ES_PASSWORD'],
            'db_name' => $ini['es_db_name'],
        ]
    ),
))->run(...array_slice($argv, 1));
