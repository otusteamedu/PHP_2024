<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\UseCase;

use IraYu\Hw12\Application;
use IraYu\Hw12\Domain\Repository;

class PurgeEvents
{
    private Repository\EventRepositoryInterface $eventRepository;

    public function __construct(
        Request\DefaultRequest $request,
    ) {
        $this->eventRepository = $request->eventRepository;
    }

    public function run(): void
    {
        $this->eventRepository->clear();
    }
}
