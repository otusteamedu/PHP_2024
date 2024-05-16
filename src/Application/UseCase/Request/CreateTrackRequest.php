<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class CreateTrackRequest
{
    public function __construct(
        public string $author,
        public string $genre,
        public int $duration,
    ) {
    }
}
