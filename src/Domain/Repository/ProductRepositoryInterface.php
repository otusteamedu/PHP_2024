<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Dto\SearchCondition;
use App\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * @param SearchCondition[] $params
     * @return Product[]
     */
    public function search(array $params): array;
}