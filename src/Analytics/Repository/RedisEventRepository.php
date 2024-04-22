<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Repository;

use AlexanderGladkov\Analytics\Entity\Event;
use Redis;
use Exception;

class RedisEventRepository implements EventRepositoryInterface
{
    private string $eventsKey = 'events';


    public function __construct(private readonly Redis $redis)
    {
    }

    /**
     * @param Event $event
     * @return void
     * @throws EventRepositoryException
     */
    public function add(Event $event): void
    {
        try {
            $this->redis->zAdd($this->eventsKey, $event->getPriority(), serialize($event));
        } catch (Exception $e) {
            throw new EventRepositoryException($e->getMessage());
        }
    }

    /**
     * @return void
     * @throws EventRepositoryException
     */
    public function deleteAll(): void
    {
        try {
            $this->redis->del($this->eventsKey);
        } catch (Exception $e) {
            throw new EventRepositoryException($e->getMessage());
        }
    }

    /**
     * @param array $conditions
     * @return Event|null
     * @throws EventRepositoryException
     */
    public function find(array $conditions): ?Event
    {
        try {
            $step = 1000;
            $start = 0;
            do {
                $end = $start + $step - 1;
                $serializedEvents = $this->redis->zRevRange($this->eventsKey, $start, $end);
                foreach ($serializedEvents as $serializedEvent) {
                    /**
                     * @var Event $event
                     */
                    $event = unserialize($serializedEvent);
                    if ($event->meetConditions($conditions)) {
                        return $event;
                    }
                }

                $start = $end + 1;
            } while (count($serializedEvents) === $step);

            return null;
        } catch (Exception $e) {
            throw new EventRepositoryException($e->getMessage());
        }
    }
}
