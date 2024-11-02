<?php

namespace Komarov\Hw14\App;

class IdentityMap {
    private array $entities = [];

    public function add(int $id, Product $product): void {
        $this->entities[$id] = $product;
    }

    public function get(int $id): ?Product {
        return $this->entities[$id] ?? null;
    }
}
