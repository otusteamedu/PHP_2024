<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\ValueObject\Genre;

readonly class NewTrackCreatedEvent
{
    public function __construct(
        public Genre $genre,
    ) {
    }
}
