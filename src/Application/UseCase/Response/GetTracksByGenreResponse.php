<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class GetTracksByGenreResponse
{
    public function __construct(
        public array $tracks,
    ) {
    }
}
