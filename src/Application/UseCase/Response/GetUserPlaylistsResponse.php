<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Domain\Collection\PlaylistCollection;

readonly class GetUserPlaylistsResponse
{
    public function __construct(
        public PlaylistCollection $playlists,
    ) {
    }
}
