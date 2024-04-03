<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing;

use Redis;

class RedisEventRepository
{
    public function __construct(
        private readonly Redis $redis,
    ) {
    }

    public function addEvent(): void
    {

    }

    public function clearEvents(): void
    {

    }

    public function findTheMostSuitableEvent(): array
    {
        return [];
    }
}
