<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class GetUserPlaylistsResponse
{
    public function __construct(
        public array $playlists,
    ) {
    }
}
