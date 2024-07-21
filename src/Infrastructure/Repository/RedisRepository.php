<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\ResponseDTO\ClearAllResponse;
use App\Domain\Collection\ConditionCollection;
use App\Domain\Entity\Event;
use App\Domain\ValueObject\Condition;
use App\Domain\ValueObject\Uid;
use Exception;
use Redis;

class RedisRepository implements \App\Domain\Repository\IRepository
{
    public function __construct(private Redis $client)
    {
    }

    public function add(Event $event): Event
    {
        try {
            $eventId = $this->client->incr('event:id_counter');
            $this->client->multi();
            $this->client->hmset("event:{$eventId}", [
                'uid' => $eventId,
                'priority' => $event->getPriority()->getValue(),
                'conditions' => json_encode($event->getConditions()->toArray()),
            ]);

            foreach ($event->getConditions() as $condition) {
                $this->client->zadd(
                    "condition:{$condition->getParamName()}:{$condition->getParamValue()}",
                    $event->getPriority()->getValue(),
                    "event:{$eventId}"
                );
            }

            $response = $this->client->exec();

            if (!$response) {
                throw new Exception("Add event failed");
            }

            $event->setUid(new Uid($eventId));
            return $event;
        } catch (Exception $e) {
            $this->client->discard();
            $this->client->decr('event:id_counter');
            throw new Exception("Rollback incrementation : " . $e->getMessage());
        }
    }

    public function findEvent(ConditionCollection $conditionCollection): ?Event
    {
        if ($conditionCollection->count() == 1) {
            $eventIdlist = $this->findEventIdListByCondition(current($conditionCollection));
        } else {
            $eventIdlist = $this->findEventIdListByConditionCollection($conditionCollection);
        }

        $result = [];
        foreach ($eventIdlist as $eventId) {
            $result = $this->client->hGetAll($eventId);
            if (json_encode($conditionCollection->toArray()) == $result['conditions']) {
                break;
            }
        }
        if (empty($result)) {
            throw new Exception("Event not found");
        }
        return (new RedisEventBuilder($result))();
    }

    public function clearAll(): ClearAllResponse
    {
        $result = $this->client->flushDB();
        return new ClearAllResponse($result);
    }

    public function findEventIdListByConditionCollection(ConditionCollection $conditionCollection): array
    {
        $zInterStoreArray = [];
        foreach ($conditionCollection as $condition) {
            $zInterStoreArray[] = "condition:{$condition->getParamName()}:{$condition->getParamValue()}";
        }
        $this->client->zInterStore('temp_result', $zInterStoreArray);
        $results = $this->client->zRevRange('temp_result', 0, -1);
        return $results;
    }

    public function findEventIdListByCondition(Condition $condition): array
    {
        return $this->client->zRevRange("event:{$condition->getParamName()}:{$condition->getParamValue()}", 0, -1);
    }
}
