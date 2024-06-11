<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class GetTracksByGenreRequest
{
    public function __construct(
        public ?string $genre = null,
    ) {
    }
}
