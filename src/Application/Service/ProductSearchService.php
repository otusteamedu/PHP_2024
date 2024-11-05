<?php
namespace App\Application\Service;

use App\Domain\Repository\ProductRepository;

class ProductSearchService {
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository) {
        $this->repository = $repository;
    }

    public function search(string $query, ?float $maxPrice = null): array {
        return $this->repository->search($query, $maxPrice);
    }
}
