<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Factory;

use AlexanderPogorelov\Redis\Config;
use AlexanderPogorelov\Redis\Entity\Event;
use Ramsey\Uuid\Uuid;

class EventFactory
{
    private Config $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * @return Event[]
     */
    public function generateEvents(): array
    {
        $eventsCount = $this->config->getEventsCount();
        $priorityRange = range(1000, 10000, 500);
        $priorityRangeLength = count($priorityRange);
        $parameterNames = $this->config->getParameterNames();
        $parameterNamesLength = count($parameterNames);
        $events = [];

        for ($i = 0; $i < $eventsCount; $i++) {
            $parametersLength = rand(1, $parameterNamesLength);
            $conditions = [];

            for ($j = 0; $j < $parametersLength; $j++) {
                $conditions[$parameterNames[$j]] = rand(1, 5);
            }

            $event = new Event(
                $i + 1,
                $priorityRange[rand(0, $priorityRangeLength - 1)],
                $conditions,
                Uuid::uuid4()->toString(),
            );
            $events[] = $event;
        }

        return $events;
    }
}
