<?php

return [
    'rabbitmq' => [
        'host' => 'rabbitmq',
        'port' => 5672,
        'user' => 'developer',
        'password' => 'secret',
        'queue_name' => 'default_queue',
    ],
    'redis' => [
        'scheme' => 'tcp',
        'host' => 'redis',
        'port' => 6379,
    ],
    'mail' => [
        'driver' => 'smtp',
        'host' => 'mailhog',
        'port' => 1025,
        'dsn' => 'smtp://mailhog:1025',
    ],
];