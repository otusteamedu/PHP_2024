<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\DTO\GetUserPlaylistDto;

readonly class GetUserPlaylistsResponse
{
    public function __construct(
        /**
         * @var GetUserPlaylistDto[] $playlists
         */
        public array $playlists,
    ) {
    }
}
