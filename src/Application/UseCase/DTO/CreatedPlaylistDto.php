<?php

declare(strict_types=1);

namespace App\Application\UseCase\DTO;

readonly class CreatedPlaylistDto
{
    public function __construct(
        public int $id,
    ) {
    }
}
