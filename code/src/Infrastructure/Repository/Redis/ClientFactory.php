<?php

declare(strict_types=1);

namespace IraYu\Hw12\Infrastructure\Repository\Redis;

class ClientFactory
{
    public static function create(
        string $host,
        int $port,
        ?string $user,
        ?string $password,
        ?int $dbNumber,
    ): \Redis {
        $redisClient = new \Redis();
        $redisClient->connect($host, $port);
        if (!empty($dbNumber)) {
            $redisClient->select($dbNumber);
        }

        if (!$redisClient->ping()) {
            throw new \RuntimeException('Could not connect to Redis');
        }

        return $redisClient;
    }
}
