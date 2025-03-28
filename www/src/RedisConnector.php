<?php

declare(strict_types=1);

namespace Builov\RedisApp;

use Redis;
use RedisException;

class RedisConnector implements DbConnector
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        try {
            $this->redis->connect('redis-server', 6379);
        } catch (RedisException $ex) {
            echo "Connection to server failed.";
            exit;
        }
    }

    /**
     * @throws RedisException
     */
    public function flushDb(): bool
    {
        return $this->redis->flushDB();
    }

    /**
     * @param string $key
     *
     * @return array
     *
     * @throws RedisException
     */
    public function getSetMembers(string $key): array
    {
        return $this->redis->sMembers($key);
    }

    /**
     * @param string $key
     * @param array $values key → value array
     *
     * @return bool|Redis
     *
     * @throws RedisException
     *
     */
    public function addToHashMulti(string $key, array $values): bool|Redis
    {
        return $this->redis->hMSet($key, $values);
    }

    /**
     * Adds a values to the set value stored at key.
     *
     * @param string $key
     * @param string $value
     *
     * @return int|bool
     *
     * @throws RedisException
     */
    public function addToSet(string $key, string $value): int|bool
    {
        return $this->redis->sAdd($key, $value);
    }

    /**
     * @param string $key
     *
     * @return array
     *
     * @throws RedisException
     */
    public function getHashMembers(string $key): array
    {
        return $this->redis->hGetAll($key);
    }
}
