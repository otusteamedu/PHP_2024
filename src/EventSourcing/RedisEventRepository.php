<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing;

use Alogachev\Homework\EventSourcing\Event\StoredEvent;
use Redis;
use RedisException;

class RedisEventRepository
{
    private const STORAGE_KEY = 'event-system:events';

    public function __construct(
        private readonly Redis $redis,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function addEvent(StoredEvent $event): void
    {
        $key = self::STORAGE_KEY;
        foreach ($event->conditions() as $condition) {
            $key .= ':'. $condition;
        }

        $this->redis->zAdd($key, $event->priority(), serialize($event));
    }

    /**
     * @throws RedisException
     */
    public function clearEvents(): void
    {
        $iterator = null;
        $keys = $this->redis->scan($iterator, self::STORAGE_KEY . '*');

        if (!$keys) {
            return;
        }

        foreach ($keys as $key) {
            $this->redis->del($key);
        }
    }

    public function findTheMostSuitableEvent(): array
    {
        return [];
    }
}
