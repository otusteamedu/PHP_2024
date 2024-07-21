<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Collection\ConditionCollection;
use App\Domain\Entity\Event;
use App\Domain\ValueObject\Condition;
use App\Domain\ValueObject\Priority;
use App\Domain\ValueObject\Uid;

class RedisEventBuilder
{
    public function __construct(private array $rawData)
    {
    }

    public function __invoke()
    {
        $event = new Event(
            $this->getPriorityFromRawData(),
            $this->getConditionCollectionFromRawData()
        );
        $event->setUid($this->getUidFromRawData());
        return $event;
    }

    private function getUidFromRawData(): Uid
    {
        if (!isset($this->rawData['uid'])) {
            throw new \Exception("Event uid must be set");
        }
        $uid = $this->rawData['uid'];
        $uid = intval($uid);
        return new Uid($uid);
    }

    private function getPriorityFromRawData(): Priority
    {
        if (!isset($this->rawData['priority'])) {
            throw new \Exception("Priority must be set");
        }
        $priority = $this->rawData['priority'];
        $priority = intval($priority);
        return new Priority($priority);
    }

    private function getConditionCollectionFromRawData(): ConditionCollection
    {
        if (!isset($this->rawData['conditions'])) {
            throw new \Exception("Conditions must be set");
        }
        $conditionsArray = json_decode($this->rawData['conditions'], true);
        if (json_last_error()) {
            throw new \Exception("Invalid conditions json decode: " . json_last_error_msg());
        }

        $conditionCollection = new ConditionCollection();
        foreach ($conditionsArray as $paramName => $paramValue) {
            $paramName = strval($paramName);
            $paramValue = strval($paramValue);
            $conditionCollection->add(new Condition($paramName, $paramValue));
        }
        return $conditionCollection;
    }
}
