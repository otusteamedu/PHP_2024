<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\DTO\CreatedTrackDto;

readonly class CreateTrackResponse
{
    public function __construct(
        public CreatedTrackDto $track,
    ) {
    }
}
