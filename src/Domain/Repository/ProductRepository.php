<?php
namespace App\Domain\Repository;

interface ProductRepository {
    public function search(string $query, ?float $maxPrice = null): array;
}
