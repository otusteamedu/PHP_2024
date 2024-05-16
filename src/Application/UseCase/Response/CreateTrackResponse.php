<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class CreateTrackResponse
{
    public function __construct(
        public int $id,
    ) {
    }
}
