<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Track;

interface ITrackRepository
{
    public function save(Track $track): void;
}
