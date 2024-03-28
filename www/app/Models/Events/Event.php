<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\Models\Events;

use Hukimato\RedisApp\Models\AbstractDbModel;
use Hukimato\RedisApp\Models\DbTraits\RedisTrait;

class Event implements AbstractDbModel
{
    use RedisTrait;

    public int $priority;

    public string $eventName;

    public array $params;

    public function __construct(array $rawParams)
    {
        $this->priority = $rawParams['priority'] ?? 0;
        $this->eventName = $rawParams['eventName'] ?? '';
        $this->params = $rawParams['params'] ?? [];
    }
}
