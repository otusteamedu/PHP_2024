<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Playlist;

interface IPlaylistRepository
{
    public function save(Playlist $track): void;
}
