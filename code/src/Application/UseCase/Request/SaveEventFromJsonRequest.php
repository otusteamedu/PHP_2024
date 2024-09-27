<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\UseCase\Request;

use IraYu\Hw12\Domain\Repository;

class SaveEventFromJsonRequest
{
    public function __construct(
        public readonly Repository\EventRepositoryInterface $eventRepository,
        public readonly string $jsonString,
    ) {
    }
}
