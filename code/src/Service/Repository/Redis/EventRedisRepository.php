<?php

declare(strict_types=1);

namespace App\Service\Repository\Redis;

use App\Repository\EventRepositoryInterface;
use App\Service\Entity\Event;
use App\Service\Entity\EventParam;
use App\Service\RedisConnectorService;

class EventRedisRepository implements EventRepositoryInterface
{
    public function __construct(private RedisConnectorService $redisConnectorService)
    {
    }

    public function getAll(): ?array {
        $redis = $this->redisConnectorService->connect();
        $hGetAll = $redis->hGetAll("events");
        foreach ($hGetAll as $serialized) {
            $result[] = unserialize($serialized);
        }
        return $result ?? null;
    }

    public function save(Event $event): void
    {
        $eventId = $event->getId();
        $redis = $this->redisConnectorService->connect();

        $serializedEvent = $redis->get($eventId);
        if(!$serializedEvent) {
            $serializedEvent = serialize($event);
            $redis->multi();
            $redis->hSet("events", $eventId, $serializedEvent);
            $redis->zAdd("priority", $event->getPriority(), $eventId);

            /**
             * @var EventParam $param
             */
            foreach ($event->getParams() as $param) {
                $redis->sAdd("set:" . $eventId, $param->getTitle() . ":" . $param->getValue());
            }
            $redis->exec();
        }
    }

    public function removeAll(): void
    {
        $redis = $this->redisConnectorService->connect();
        $redis->flushDB();
    }

    /**
     * @param EventParam[] $params
     */
    public function getRelevant(array $eventParams) : ?Event
    {
        $redis = $this->redisConnectorService->connect();
        $arEventsIds = $redis->hKeys("events");

        foreach ($eventParams as $param)
        {
            $redis->sAdd("set:eventRequest", $param->getTitle() . ":" . $param->getValue());
        }

        foreach ($arEventsIds as $eventId)
        {
            $redis->sUnionStore("set:UnionStore", "set:eventRequest", "set:{$eventId}");
            $arDiff = $redis->sDiff("set:UnionStore", "set:eventRequest");
            if(empty($arDiff)) {
                $arRelevantIds[] = $eventId;
            }
            $redis->del("set:UnionStore");
        }

        if(!empty($arRelevantIds))
        {
            $range = $redis->zRangeByScore('priority', "-inf", "+inf");
            foreach ($range as $eventId) {
                if(in_array($eventId, $arRelevantIds)) {
                    $relevantSerialized = $redis->hGet("events", $eventId);
                    $event = unserialize($relevantSerialized);
                    break;
                }
            }
        }

        $redis->del("set:eventRequest");
        return $event ?? null;
    }
}