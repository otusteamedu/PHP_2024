<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Repository;

use AlexanderPogorelov\Redis\Entity\Event;
use AlexanderPogorelov\Redis\Exception\StorageException;
use AlexanderPogorelov\Redis\Search\SearchCriteria;
use AlexanderPogorelov\Redis\Storage\RedisStorage;

/**
 * @property RedisStorage $storage
 */
class EventRedisRepository implements EventRepositoryInterface
{
    public const CACHE_KEY = 'events';

    private RedisStorage $storage;

    public function __construct()
    {
        $this->storage = new RedisStorage();
    }

    public function add(Event $event): void
    {
        try {
            $this->storage->getConnection()->zAdd(
                self::CACHE_KEY,
                $event->getPriority(),
                serialize($event)
            );
        } catch (\Throwable $e) {
            throw new StorageException($e->getMessage());
        }
    }

    public function clearAll(): void
    {
        try {
            $keys = $this->storage->getConnection()->keys(self::CACHE_KEY);

            if (0 === count($keys)) {
                return;
            }

            $this->storage->getConnection()->del(...$keys);
        } catch (\Throwable $e) {
            throw new StorageException($e->getMessage());
        }
    }

    public function findByCriteria(SearchCriteria $criteria): ?Event
    {
        $total = $this->getTotal();

        if (0 === $total) {
            return null;
        }

        $position = 0;

        try {
            do {
                $current = $this->storage->getConnection()->zRevRange(self::CACHE_KEY, $position, $position);
                /** @var Event $event */
                $event = unserialize($current[0]);

                if ($criteria->match($event->getConditions())) {
                    return $event;
                }

                $position++;
            } while ($position < $total);

            return null;
        } catch (\Throwable $e) {
            throw new StorageException($e->getMessage());
        }
    }

    public function getTotal(): int
    {
        try {
            $total = $this->storage->getConnection()->zCard(self::CACHE_KEY);

            if (!is_int($total)) {
                throw new \Exception('Unable to count events');
            }

            return $total;
        } catch (\Throwable $e) {
            throw new StorageException($e->getMessage());
        }
    }
}
