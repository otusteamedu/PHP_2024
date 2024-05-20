<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\GetTracksByGenreRequest;
use App\Application\UseCase\Response\GetTracksByGenreResponse;
use App\Domain\Repository\ITrackRepository;
use App\Domain\Service\INormalizer;
use App\Domain\ValueObject\Genre;

class GetTracksByGenreUseCase
{
    public function __construct(
        private readonly ITrackRepository $trackRepository,
        private readonly INormalizer $trackNormalizer,
    ) {
    }

    public function __invoke(GetTracksByGenreRequest $request): GetTracksByGenreResponse
    {
        $tracks = $this->trackRepository->getTracksByGenre(new Genre($request->genre));
        $normalizedTracks = [];
        foreach ($tracks as $track) {
            $normalizedTracks[] = $this->trackNormalizer->normalize($track);
        };

        return new GetTracksByGenreResponse($normalizedTracks);
    }
}
