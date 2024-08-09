<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry\Adapter;

use Generator;
use Redis;
use Viking311\Analytics\Registry\Adapter\AdapterInterface;
use Viking311\Analytics\Registry\EventEntity;

class RedisAdapter implements AdapterInterface
{
    /**
    * @param Redis $redisClient
     */
    public function __construct(private Redis $redisClient)
    {
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->redisClient->flushDB();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param integer $priority
     * @return boolean
     */
    public function add(string $key, mixed $value, $priority = 0): bool
    {
        return (bool) $this->redisClient->zAdd($key, $priority, $value);
    }

    /**
     * @param string $key
     * @return Generator
     */
    public function getByKey(string $key): Generator
    {
        $rawSet = $this->redisClient->zRevRangeByScore($key, '+inf', '-inf', ['withscores' => true]);
        if (!is_array($rawSet)) {
            return;
        }

        foreach ($rawSet as $value => $score) {
            $data = json_decode($value);
            $data->priority = $score;
            $event = new EventEntity($data);
            yield $event;
        }
    }
}
