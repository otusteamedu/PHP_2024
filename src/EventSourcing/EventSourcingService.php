<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing;

class EventSourcingService
{
    public function __construct(
        private readonly EventRepository $eventRepository,
    ) {
    }

    public function addEvent(array $data): void
    {
        
    }

    public function clearEvents(): void
    {
        
    }

    public function findTheMostSuitableEvent(): array
    {
        return [];
    }
}
