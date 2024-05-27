<?php

declare(strict_types=1);

namespace App\Application\UseCase\DTO;

readonly class GetUserPlaylistDto
{
    public function __construct(
        public int $id,
        public string $name,
        public array $tracks,
    ) {
    }
}
