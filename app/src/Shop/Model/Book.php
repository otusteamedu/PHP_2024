<?php

declare(strict_types=1);

namespace App\Shop\Model;

final readonly class Book
{
    public function __construct(
        public string $title,
        public string $sku,
        public string $category,
        public int $price,
        /** @var Stock[] $stocks */
        public array $stocks,
    ) {}

    public function getTotalStockCount(): int
    {
        return array_sum(
            array_map(fn(Stock $stock) => $stock->stock, $this->stocks)
        );
    }
}