<?php

namespace AKornienko\Php2024\Application\CreateEvent;

use AKornienko\Php2024\Application\CreateEvent\request\CreateEventRequest;
use AKornienko\Php2024\Application\EventsRepository;

readonly class EventCreator
{
    public function __construct(private EventsRepository $repository)
    {
    }

    public function __invoke(CreateEventRequest $request): string
    {
        return $this->repository->addEvent($request);
    }
}
