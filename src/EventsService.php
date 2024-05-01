<?php

declare(strict_types=1);

namespace AShutov\Hw15;

use AShutov\Hw15\Requests\AddEventRequest;
use AShutov\Hw15\Requests\GetEventRequest;
use RedisException;

class EventsService
{
    const ADD_EVENT = "event был добавлен";
    const NO_ADD_EVENT = "event не был добавлен";
    const NO_EVENT = "event не найден";
    const EVENTS_REMOVED = "все events были удалены";
    const EVENTS_NOT_REMOVED = "events не были удалены";
    private StorageClientInterface $client;

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
