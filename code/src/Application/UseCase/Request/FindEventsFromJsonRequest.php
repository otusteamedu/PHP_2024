<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\UseCase\Request;

use IraYu\Hw12\Domain\Repository;

class FindEventsFromJsonRequest
{
    public function __construct(
        public readonly Repository\EventRepositoryInterface $eventRepository,
        public readonly string $jsonString,
    ) {
    }
}