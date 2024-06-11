<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class SubscribeNewGenreRecordsRequest
{
    public function __construct(
        public ?string $user = null,
        public ?string $genre = null,
    ) {
    }
}
