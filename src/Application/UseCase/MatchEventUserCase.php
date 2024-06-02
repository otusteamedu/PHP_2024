<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Response\EventResponse;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\EventRepositoryInterface;

readonly class MatchEventUserCase
{
    public function __construct(private EventRepositoryInterface $eventRepository)
    {
    }

    /**
     * @throws DomainException|NotFoundException
     */
    public function __invoke(array $condition): ?EventResponse
    {
        $event = $this->eventRepository->matchByCondition($condition);
        return new EventResponse($event->getEvent(), $event->getPriority(), $event->getCondition());
    }
}
