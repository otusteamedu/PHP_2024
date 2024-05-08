<?php

namespace AKornienko\Php2024\Application\DeleteEvents;

use AKornienko\Php2024\Application\EventsRepository;

readonly class EventsDeleter
{
    public function __construct(private EventsRepository $repository)
    {
    }

    public function __invoke(): string
    {
        return $this->repository->removeAllEvents();
    }
}
