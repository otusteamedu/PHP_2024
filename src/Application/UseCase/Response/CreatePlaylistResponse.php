<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\DTO\CreatedPlaylistDto;

readonly class CreatePlaylistResponse
{
    public function __construct(
        public CreatedPlaylistDto $playlist,
    ) {
    }
}
