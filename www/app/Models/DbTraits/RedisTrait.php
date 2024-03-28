<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\Models\DbTraits;

use Exception;
use Redis;
use RedisException;

trait RedisTrait
{

    const TMP_KEY = 'res&';

    /**
     * @throws RedisException
     */
    static function find(array $params): static
    {
        $redisClient = static::getClient();

        array_walk($params, function (&$key, $val) {
            $key = "$val:$key";
        });

        $redisClient->zinterstore(static::TMP_KEY, $params, array_fill(0, count($params), 1), 'max');
        $data = $redisClient->zPopMax(static::TMP_KEY);

        if (!$data) {
            http_response_code(404);
            throw new Exception("Not found", 404);
        }

        $eventName = array_key_first($data);

        return new static([
            'eventName' => $eventName,
            'priority' => (int)$data[$eventName]
        ]);
    }

    public function save(): bool
    {
        $redisClient = static::getClient();

        foreach ($this->params as $param => $val) {
            $redisClient->zAdd("$param:$val", $this->priority, $this->eventName);
        }

        return true;
    }

    static function deleteAll(): bool
    {
        $redisClient = static::getClient();

        $redisClient->flushAll();

        return true;
    }

    protected static function getClient(): Redis
    {
        $redis = new Redis();
        $redis->connect('redis');
        $redis->auth(['default', 'hukimato']);
        return $redis;
    }
}
