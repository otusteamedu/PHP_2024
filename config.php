<?php

declare(strict_types=1);

return [
    'redis' => [
        'host' => getenv('REDIS_HOST'),
        'port' => (int)getenv('REDIS_PORT'),
        'connectTimeout' => 2.5,
        'backoff' => [
            'algorithm' => Redis::BACKOFF_ALGORITHM_DECORRELATED_JITTER,
            'base' => 500,
            'cap' => 750,
        ],
    ],
];
