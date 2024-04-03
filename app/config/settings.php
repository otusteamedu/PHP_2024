<?php

$env = parse_ini_file(__DIR__ . '/../../.env');

return [
    'connections' => [
        'elastic' => [
            'host' => $env['ELASTIC_HOST'] ?? 'elasticsearch',
            'port' => $env['ELASTIC_PORT'] ?? '9200',
            'username' => $env['ELASTIC_USERNAME'] ?? '',
            'password' => $env['ELASTIC_PASSWORD'] ?? '',
        ],
        'redis' => [
            'host' => $env['REDIS_HOST'] ?? 'redis',
            'port' => $env['REDIS_PORT'] ?? '6379',
            'username' => $env['REDIS_USERNAME'] ?? '',
            'password' => $env['REDIS_password'] ?? '',
        ],
    ]
];
