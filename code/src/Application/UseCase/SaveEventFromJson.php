<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\UseCase;

use IraYu\Hw12\Application;
use IraYu\Hw12\Domain\Repository;

class SaveEventFromJson
{
    private Repository\EventRepositoryInterface $eventRepository;

    private string $jsonString;

    public function __construct(
        Request\SaveEventFromJsonRequest $request,
    ) {
        $this->eventRepository = $request->eventRepository;
        $this->jsonString = $request->jsonString;
    }

    public function run(): Response\SaveEventFromJsonResponse
    {
        $event = Application\Event\EventFactory::createFromJson(
            $this->jsonString
        );

        $this->eventRepository->save(
            $event
        );

        return new Response\SaveEventFromJsonResponse(
            $event
        );
    }
}
