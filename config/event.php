<?php

use App\Services\RedisHandlerService;

/*
 * Define event handlers.
 */
return [
    'default' => 'redis',

    'handlers' => [
        'redis' => RedisHandlerService::class
    ]
];
