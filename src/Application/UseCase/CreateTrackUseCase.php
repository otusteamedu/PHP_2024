<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\EventSourcing\IEventPublisher;
use App\Application\UseCase\DTO\CreatedTrackDto;
use App\Application\UseCase\Request\CreateTrackRequest;
use App\Application\UseCase\Response\CreateTrackResponse;
use App\Domain\Entity\Track;
use App\Domain\Event\NewTrackCreatedEvent;
use App\Domain\Repository\ITrackRepository;
use App\Domain\ValueObject\Genre;
use App\Domain\ValueObject\TrackDuration;

class CreateTrackUseCase
{
    public function __construct(
        private readonly ITrackRepository $trackRepository,
        private readonly IEventPublisher $eventManager,
    ) {
    }

    public function __invoke(CreateTrackRequest $request): CreateTrackResponse
    {
        $track = new Track(
            $request->name,
            $request->author,
            new Genre($request->genre),
            new TrackDuration($request->duration),
        );
        $this->trackRepository->save($track);
        $this->eventManager->notify(new NewTrackCreatedEvent($track->getGenre()));

        return new CreateTrackResponse(new CreatedTrackDto($track->getId()));
    }
}
