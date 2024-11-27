<?php

return [
    'redis' => [
        'scheme' => 'tcp',
        'host'   => getenv('REDIS_HOST'),
        'port'   => getenv('REDIS_PORT'),
    ]
];