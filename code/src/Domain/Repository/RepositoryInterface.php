<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface RepositoryInterface
{
    public function save(Product $product): int;
    public function delete(int $id): void;
    public function getProduct(int $id): Product;
    public function setStatus(int $status, int $id): void;
    public function getStatus(int $id): int;



}