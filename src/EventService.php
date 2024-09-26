<?php

declare(strict_types=1);

namespace Afilipov\Hw12;

readonly class EventService
{
    public function __construct(private EventStorage $storage, private EventHelper $eventHelper)
    {
    }

    public function addEvent(Event $event): void
    {
        $this->storage->addEvent($event);
    }

    public function clearEvents(): void
    {
        $this->storage->clearEvents();
    }

    public function getEventByUserRequest(UserRequest $userRequest): ?Event
    {
        $events = $this->storage->getEvents();
        if (empty($events)) {
            return null;
        }

        $eventByUserConditions = null;

        foreach ($events as $event) {
            if ($this->eventHelper->checkConditions($event, $userRequest)) {
                $eventByUserConditions = $event;
                break;
            }
        }

        return $eventByUserConditions;
    }
}
