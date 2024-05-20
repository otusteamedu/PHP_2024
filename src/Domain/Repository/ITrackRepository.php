<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Track;
use App\Domain\ValueObject\Genre;

interface ITrackRepository
{
    /**
     * @param Genre $genre
     * @return Track[]
     */
    public function getTracksByGenre(Genre $genre): array;

    public function save(Track $track): void;
}
