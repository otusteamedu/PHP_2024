<?php

namespace App\Domain\Service;

use App\Domain\Entity\Product;
use App\Infrastructure\Repository\ProductRepository;

class ProductService
{
    private ProductRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function create(Product $product): ?Product
    {
        return $this->repository->create($product);
    }

    public function findById(string $id): ?Product
    {
        return $this->repository->findById($id);
    }

    /**
     * @param array $criteriaArray
     * @return Product[]|null
     */
    public function findByCriteria(array $criteriaArray): ?array
    {
        return $this->repository->findByCriteria($criteriaArray);
    }

    public function update(Product $product): bool
    {
        return $this->repository->update($product);
    }

    public function remove(Product $product): bool
    {
        return $this->repository->remove($product);
    }

    public function loadProductArrayFromFile(string $json): string
    {
        return $this->repository->loadProductArrayFromFile($json);
    }
}
