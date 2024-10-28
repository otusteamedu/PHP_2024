<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Subscribe;
use App\Domain\ValueObject\Category;

interface SubscribeRepositoryInterface
{
    public function save(Subscribe $subscribe): void;

    public function getByCategory(Category $category): array;
}
