<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\UseCase;

use IraYu\Hw12\Application;
use IraYu\Hw12\Domain\Repository;
use IraYu\Hw12\Domain\Entity;

class FindEvents
{
    private Repository\EventRepositoryInterface $eventRepository;
    private string $jsonFilter;

    public function __construct(
        Request\FindEventsFromJsonRequest $request,
    ) {
        $this->eventRepository = $request->eventRepository;
        $this->jsonFilter = $request->jsonString;
    }

    /**
     * @return Entity\Event[]
     */
    public function run(): array
    {
        $properties = Application\Event\EventPropertyFactory::createListFromJson($this->jsonFilter);

        return $this->eventRepository->findByProperties($properties);
    }
}
