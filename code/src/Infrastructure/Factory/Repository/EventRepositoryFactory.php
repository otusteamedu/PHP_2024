<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Factory\Repository;

use Redis;
use RedisException;
use Viking311\Api\Infrastructure\Config\Config;
use Viking311\Api\Infrastructure\Repository\EventRepository;

class EventRepositoryFactory
{
    /**
     * @throws RedisException
     */
    public static function createInstance(): EventRepository
    {
        $config = new Config();

        $redisClient = new Redis([
            'host' => $config->redis->redisHost,
            'port' => $config->redis->redisPort
        ]);

        $redisClient->select(0);

        return new EventRepository($redisClient);
    }
}
