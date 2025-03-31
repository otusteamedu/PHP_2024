<?php

declare(strict_types=1);

namespace Aware\App\Infrastructure\Event;

use Aware\App\Domain\Event\Event;
use Aware\App\Domain\Event\EventRepositoryInterface;
use Aware\App\Infrastructure\Redis\RedisClient;

class EventRedisRepository implements EventRepositoryInterface
{
    private RedisClient $redisClient;
    public function __construct()
    {
        $this->redisClient = new RedisClient();
    }
    public function addEvent(Event $event): void
    {
        foreach ($event->conditions as $key => $condition) {
            $cacheKey = $key . ':' . $condition;
            $this->redisClient->zAdd($cacheKey, $event->priority, json_encode($event));
        }
    }

    public function getBestEvent(array $conditions): Event
    {
        $bestEvent = null;

        foreach ($conditions as $conditionKey => $conditionValue) {
            $eventsByCondition = $this->redisClient->zRevRange($conditionKey . ':' . $conditionValue, 0, -1);

            foreach ($eventsByCondition as $json) {
                $event = Event::decode($json);

                if ($event->hasAllConditions($conditions) && $event->isBetterThanLast($bestEvent)) {
                    $bestEvent = $event;
                    break;
                }
            }
        }

        return $bestEvent;
    }

    public function deleteEvents(): void
    {
        $this->redisClient->deleteAll();
    }

    public function migrate(EventRedisRepository $eventRepository): void
    {
        $events = $this->redisClient->getAllEvents();

        foreach ($events as $event) {
            $eventRepository->addEvent($event);
        }
    }
}
