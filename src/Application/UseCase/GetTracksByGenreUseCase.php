<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Mapper\IObjectMapper;
use App\Application\UseCase\DTO\TrackDto;
use App\Application\UseCase\Request\GetTracksByGenreRequest;
use App\Application\UseCase\Response\GetTracksByGenreResponse;
use App\Domain\Repository\ITrackRepository;
use App\Domain\ValueObject\Genre;

class GetTracksByGenreUseCase
{
    public function __construct(
        private readonly ITrackRepository    $trackRepository,
        private readonly IObjectMapper $mapper,
    ) {
    }

    public function __invoke(GetTracksByGenreRequest $request): GetTracksByGenreResponse
    {
        $tracks = $this->trackRepository->getTracksByGenre(new Genre($request->genre));
        $normalizedTracks = $this->mapper->map($tracks, TrackDto::class);

        return new GetTracksByGenreResponse($normalizedTracks);
    }
}
