<?php

declare(strict_types=1);

namespace hw15\adapters;

use hw15\entities\EventEntity;

use \Redis;

class RedisAdapter implements StorageInterface
{
    private Redis $store;

    private string $key;

    public function __construct()
    {
        $this->store = new Redis([
            'host' => getenv('REDIS_HOST'),
            'port' => (int)getenv('REDIS_PORT'),
            'connectTimeout' => 2.5
        ]);

        $this->key = md5(getenv('REDIS_KEY'));
    }

    public function get(): array
    {
        $events = $this->store->zRevRange($this->key, 0, -1);

        return empty($events) ? [] : $events;
    }

    public function delete()
    {
        $this->store->del($this->key);
    }

    public function test()
    {
        return $this->store->ping('Test redis');
    }

    public function add(EventEntity $entity)
    {
        $this->store->zAdd(
            $this->key,
            $entity->priority,
            json_encode($entity)
        );
    }
}
