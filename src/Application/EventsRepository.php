<?php

namespace AKornienko\Php2024\Application;

use AKornienko\Php2024\Application\CreateEvent\request\CreateEventRequest;
use AKornienko\Php2024\Application\GetEvents\request\GetEventsRequest;

interface EventsRepository
{
    public function addEvent(CreateEventRequest $request): string;

    public function getEvent(GetEventsRequest $request): string;

    public function removeAllEvents(): string;
}
