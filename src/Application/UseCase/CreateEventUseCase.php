<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Request\CreateEventRequest;
use App\Domain\Entity\Event;
use App\Domain\Exception\DomainException;
use App\Domain\Repository\EventRepositoryInterface;

readonly class CreateEventUseCase
{
    public function __construct(private EventRepositoryInterface $eventRepository)
    {
    }

    /**
     * @throws DomainException
     */
    public function __invoke(CreateEventRequest $request): void
    {
        $this->eventRepository->save(new Event($request->event, $request->priority, $request->condition));
    }
}