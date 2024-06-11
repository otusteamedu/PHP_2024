<?php

declare(strict_types=1);

namespace App\Application\Repository\DTO;

use App\Domain\ValueObject\Genre;

readonly class FindUserByGenreSubscriptionDto
{
    public function __construct(
        public Genre $genre,
    ) {
    }
}
