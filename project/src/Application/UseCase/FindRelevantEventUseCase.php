<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Application\UseCase;

use SFadeev\Hw12\Domain\Entity\Event;
use SFadeev\Hw12\Domain\Service\EventService;

class FindRelevantEventUseCase
{
    public function __construct(
        private EventService $eventService,
    ) {
    }

    public function handle(array $params): Event
    {
        return $this->eventService->findRelevant($params);
    }
}
