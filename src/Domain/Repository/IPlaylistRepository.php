<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Collection\PlaylistCollection;
use App\Domain\Entity\Playlist;
use App\Domain\ValueObject\Email;

interface IPlaylistRepository
{
    public function findPlaylistsByUser(Email $user): PlaylistCollection;
    public function save(Playlist $track): void;
}
