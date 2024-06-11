<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\DTO\TrackDto;

readonly class GetTracksByGenreResponse
{
    public function __construct(
        /**
         * @var TrackDto[] $tracks
         */
        public array $tracks,
    ) {
    }
}
