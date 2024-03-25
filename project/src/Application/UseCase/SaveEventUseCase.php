<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Application\UseCase;

use SFadeev\Hw12\Domain\Entity\Event;
use SFadeev\Hw12\Domain\Service\EventService;

class SaveEventUseCase
{
    public function __construct(
        private EventService $eventService,
    ) {
    }

    public function handle(Event $event): Event
    {
        return $this->eventService->save($event);
    }
}
