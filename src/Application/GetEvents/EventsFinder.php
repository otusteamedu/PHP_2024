<?php

namespace AKornienko\Php2024\Application\GetEvents;

use AKornienko\Php2024\Application\EventsRepository;
use AKornienko\Php2024\Application\GetEvents\request\GetEventsRequest;

readonly class EventsFinder
{
    public function __construct(private EventsRepository $repository)
    {
    }

    public function __invoke(GetEventsRequest $request): string
    {
        return $this->repository->getEvent($request);
    }
}
