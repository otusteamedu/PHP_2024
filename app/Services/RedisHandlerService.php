<?php

namespace App\Services;

use App\Interfaces\EventHandlerInterface;
use App\Models\Event;
use Redis;

/**
 * Redis storage handler.
 */
class RedisHandlerService implements EventHandlerInterface
{
    /**
     * @var Redis Redis driver.
     */
    protected Redis $redis;

    /**
     * Creates a new instance of redis driver.
     */
    public function __construct()
    {
        $this->redis = new Redis();
    }

    /**
     * @inheritdoc
     */
    public function add(string $fields): Event
    {

    }

    /**
     * @inheritdoc
     */
    public function find(?array $conditions = null): array
    {

    }

    /**
     * @inheritdoc
     */
    public function flush(): bool
    {

    }
}