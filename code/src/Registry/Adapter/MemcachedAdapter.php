<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry\Adapter;

use Generator;
use Memcached;
use Viking311\Analytics\Registry\EventEntity;

class MemcachedAdapter implements AdapterInterface
{
    public function __construct(private Memcached $memcached)
    {
    }

    public function flush(): void
    {
        $this->memcached->flush();
    }

    public function add(string $key, mixed $value, $priority = 0): bool
    {
        $storedData = $this->memcached->get($key);
        if (!is_array($storedData)) {
            $storedData = [];
        }

        $storedData[$value] = $priority;
        arsort($storedData);
        return $this->memcached->set($key, $storedData);
    }

    public function getByKey(string $key): Generator
    {
        $storedData = $this->memcached->get($key);
        if (!is_array($storedData)) {
            return;
        }

        foreach ($storedData as $value => $score) {
            $data = json_decode($value);
            $data->priority = $score;
            $event = new EventEntity($data);
            yield $event;
        }
    }
}
