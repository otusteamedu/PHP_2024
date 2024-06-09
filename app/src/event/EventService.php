<?php

declare(strict_types=1);

namespace Dsergei\Hw12\event;

use Dsergei\Hw12\console\ConsoleParameters;

readonly class EventService
{
    private EventHelper $helper;

    public function __construct(
        private EventStorage $storage
    ) {
        $this->helper = new EventHelper();
    }

    public function addEvent(Event $event): void
    {
        $this->storage->addEvent($event);
    }

    public function clearEvents(): void
    {
        $this->storage->clearEvents();
    }

    public function getEventByUserRequest(): ?Event
    {
        $events = $this->storage->getEvents();
        if (empty($events)) {
            return null;
        }

        $params = new ConsoleParameters();

        $eventByUserConditions = null;

        foreach ($events as $event) {
            if ($this->helper->checkConditions($event, $params)) {
                $eventByUserConditions = $event;
                break;
            }
        }

        return $eventByUserConditions;
    }
}