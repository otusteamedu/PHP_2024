<?php

declare(strict_types=1);

namespace App\Application\UseCase\DTO;

readonly class TrackDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $author,
        public string $genre,
        public string $duration,
    ) {
    }
}
