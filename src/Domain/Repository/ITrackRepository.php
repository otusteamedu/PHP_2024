<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Collection\TracksCollection;
use App\Domain\Entity\Track;
use App\Domain\ValueObject\Genre;

interface ITrackRepository
{
    public function getTracksByGenre(Genre $genre): TracksCollection;

    public function findTracksById(array $ids): TracksCollection;

    public function save(Track $track): void;
}
