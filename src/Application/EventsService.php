<?php

namespace AKornienko\Php2024\Application;

use AKornienko\Php2024\Application\CreateEvent\request\CreateEventRequest;
use AKornienko\Php2024\Application\GetEvents\request\GetEventsRequest;

class EventsService implements EventsRepository
{
    const ADD_EVENT = "Event was added";
    const NO_ADD_EVENT = "Event wasn't added";
    const NO_EVENT = "Can't find event";
    const EVENTS_REMOVED = "All events were removed";
    const EVENTS_NOT_REMOVED = "Events weren't removed";

    public function __construct(private readonly StorageClient $client)
    {
    }

    public function addEvent(CreateEventRequest $request): string
    {
        $result = $this->client->addEvent(
            $request->conditions->toString(),
            $request->priority->getValue(),
            $request->event
        );
        return $result ? self::ADD_EVENT : self::NO_ADD_EVENT;
    }

    public function getEvent(GetEventsRequest $request): string
    {
        $event = $this->client->getEvent($request->conditions->toString());
        return count($event) > 0 ? $event[0] : self::NO_EVENT;
    }

    public function removeAllEvents(): string
    {
        $result = $this->client->removeAllEvents();
        return $result ? self::EVENTS_REMOVED : self::EVENTS_NOT_REMOVED;
    }
}
