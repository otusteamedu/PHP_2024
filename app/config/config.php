<?php

declare(strict_types=1);

use Rmulyukov\Hw\Infrastructure\Repository\Elastic\ElasticEventCommandRepository;
use Rmulyukov\Hw\Infrastructure\Repository\Elastic\ElasticEventQueryRepository;
use Rmulyukov\Hw\Infrastructure\Repository\Redis\RedisEventCommandRepository;
use Rmulyukov\Hw\Infrastructure\Repository\Redis\RedisEventQueryRepository;

return [
    'storage' => 'redis',
    'redis' => [
        'host' => 'hw-redis',
        'port' => 6379,
        'commandRepository' => RedisEventCommandRepository::class,
        'queryRepository' => RedisEventQueryRepository::class
    ],
    'elastic' => [
        'host' => 'hw-elastic',
        'port' => 9200,
        'commandRepository' => ElasticEventCommandRepository::class,
        'queryRepository' => ElasticEventQueryRepository::class
    ]
];
