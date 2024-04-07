<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing;

use Alogachev\Homework\EventSourcing\Event\SearchEventQuery;
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
        $key = $this->createKeyFromConditions($event->conditions());
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

    /**
     * @throws RedisException
     */
    public function findTheMostSuitableEvent(SearchEventQuery $eventQuery): ?array
    {
        $key = $this->createKeyFromConditions($eventQuery->conditions());
        $eventsValue = $this->redis->zRevRange($key, 0, 0);

        return isset($eventsValue[0]) ? unserialize($eventsValue[0]) : null;
    }

    private function createKeyFromConditions(array $conditions): string
    {
        $key = self::STORAGE_KEY;
        foreach ($conditions as $condition) {
            $key .= ':'. $condition;
        }

        return $key;
    }
}
