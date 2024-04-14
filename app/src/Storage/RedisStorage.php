<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Storage;

use AlexanderPogorelov\Redis\Config;
use AlexanderPogorelov\Redis\Exception\StorageException;

class RedisStorage
{
    private Config $config;
    private \Redis $connection;

    /**
     * @throws StorageException
     */
    public function __construct()
    {
        $this->config = new Config();

        try {
            $this->connection = new \Redis();
            $this->connection->connect($this->config->getRedisHost(), $this->config->getRedisPort());
            $this->connection->auth(getenv("REDIS_PASSWORD"));
        } catch (\Throwable $e) {
            throw new StorageException($e->getMessage());
        }
    }

    public function getConnection(): \Redis
    {
        return $this->connection;
    }

    /**
     * @throws StorageException
     */
//    public function test(): void
//    {
//        try {
//            if (!$this->connection->ping()) {
//                throw new \Exception('Unable to connect to Redis server.');
//            }
//        } catch (\Throwable $e) {
//            throw new StorageException($e->getMessage());
//        }
//    }
}
