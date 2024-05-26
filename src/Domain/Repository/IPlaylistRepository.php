<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Playlist;
use App\Domain\ValueObject\Email;

interface IPlaylistRepository
{
    /**
     * @param Email $user
     * @return Playlist[]
     */
    public function findPlaylistsByUser(Email $user): array;
    public function save(Playlist $track): void;
}
