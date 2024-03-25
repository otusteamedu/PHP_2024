<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Application\UseCase;

use SFadeev\Hw12\Domain\Service\EventService;

class ClearEventsUseCase
{
    public function __construct(private EventService $eventService)
    {
    }

    public function handle(): void
    {
        $this->eventService->clear();
    }
}
