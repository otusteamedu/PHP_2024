<?php

namespace VSukhov\Hw12\Application\Service;

use VSukhov\Hw12\Application\DTO\ProductSearchCriteria;
use VSukhov\Hw12\Domain\Repository\ProductRepositoryInterface;

class ProductSearchService
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function searchProducts(ProductSearchCriteria $criteria): array
    {
        return $this->productRepository->search($criteria);
    }
}
