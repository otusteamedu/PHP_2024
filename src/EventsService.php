<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\requests\AddEventRequest;
use AKornienko\Php2024\requests\GetEventRequest;
use RedisException;

class EventsService
{
    const ADD_EVENT = "Event was added";
    const NO_ADD_EVENT = "Event wasn't added";
    const NO_EVENT = "Can't find event";
    const EVENTS_REMOVED = "All events were removed";
    const EVENTS_NOT_REMOVED = "Events weren't removed";
    private StorageClient $client;

    /**
     * @throws RedisException
     * @throws \Exception
     */
    public function __construct(Config $config)
    {
        $this->client = new RedisClient($config);
    }

    /**
     * @throws RedisException
     */
    public function addEvent(AddEventRequest $request): string
    {
        $result = $this->client->addEvent($request->conditions->toString(), $request);
        return $result ? self::ADD_EVENT : self::NO_ADD_EVENT;
    }

    /**
     * @throws RedisException
     */
    public function getEvent(GetEventRequest $request): string
    {
        $event = $this->client->getEvent($request->conditions->toString());
        return count($event) > 0 ? $event[0] : self::NO_EVENT;
    }

    /**
     * @throws RedisException
     */
    public function removeAllEvents(): string
    {
        $result = $this->client->removeAllEvents();
        return $result ? self::EVENTS_REMOVED : self::EVENTS_NOT_REMOVED;
    }
}
