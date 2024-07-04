<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\BookCollection;

interface BookRepositoryInterface
{
    public function search(
        ?string $title,
        ?string $category,
        ?int $minPrice,
        ?int $maxPrice,
        ?string $shopName,
        ?int $minStock
    ): BookCollection;
}
