<?php

namespace App\Domain\Repository;

use App\Domain\Entity\NameAge;

interface NameAgeRepositoryInterface
{
    public function save(NameAge $nameAge): NameAge;

    public function findByName(string $name): ?NameAge;
}
