<?php

return [
    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'default' => [
            'host' => env('REDIS_HOST', 'redis'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],
    ],
];