<?php

namespace VSukhov\Hw12\Domain\Repository;

use VSukhov\Hw12\Application\DTO\ProductSearchCriteria;

interface ProductRepositoryInterface
{
    public function search(ProductSearchCriteria $criteria): array;
}
