<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class CreatePlaylistRequest
{
    public function __construct(
        public ?string $name,
        public ?string $user,
        public array $tracks = []
    ) {
    }
}
