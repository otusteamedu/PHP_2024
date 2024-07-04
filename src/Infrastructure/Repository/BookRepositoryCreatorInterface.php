<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\BookRepositoryInterface;

interface BookRepositoryCreatorInterface
{
    public function createRepository(array $config): BookRepositoryInterface;
}
