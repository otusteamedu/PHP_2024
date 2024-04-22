<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Factory;

use AlexanderGladkov\Analytics\Entity\Event;
use AlexanderGladkov\Analytics\Request\AddRequest;

class EventEntityFactory
{
    public function createByArray(array $eventData): Event
    {
        return new Event(uniqid(), $eventData['priority'], $eventData['conditions'], $eventData['value']);
    }

    public function createByAddRequest(AddRequest $request): Event
    {
        return new Event(uniqid(), $request->getPriority(), $request->getConditions(), $request->getValue());
    }
}
