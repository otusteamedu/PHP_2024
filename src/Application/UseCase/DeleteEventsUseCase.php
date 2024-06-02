<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Exception\DomainException;
use App\Domain\Repository\EventRepositoryInterface;

readonly class DeleteEventsUseCase
{
    public function __construct(private EventRepositoryInterface $eventRepository)
    {
    }

    /**
     * @throws DomainException
     */
    public function __invoke(): void
    {
        $this->eventRepository->deleteAll();
    }
}
