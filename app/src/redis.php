<?php

declare(strict_types=1);

namespace Redis;

use Redis;
use RedisException;

function getRedisConnectionStatusMessage(): string
{
    $redis = new Redis();

    try {
        $redis->connect($_ENV['REDIS_HOST']);
        $redis->auth($_ENV['REDIS_PASSWORD']);

        $redisConnectionStatusMessage = 'Successfully connected to Redis';
    } catch (RedisException $e) {
        $redisConnectionStatusMessage = $e->getMessage();
    }

    return $redisConnectionStatusMessage;
}
