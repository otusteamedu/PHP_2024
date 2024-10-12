<?php

declare(strict_types=1);

namespace App\Search;

final readonly class Data
{
    public function __construct(
        public ?string $title = null,
        public ?string $sku = null,
        public ?string $category = null,
        public ?int $priceMin = null,
        public ?int $priceMax = null,
        public ?bool $inStock = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $priceMin = null === $data['price_min'] ? null : (int) $data['price_min'];
        $priceMax = null === $data['price_max'] ? null : (int) $data['price_max'];
        $inStock = null === $data['in_stock'] ? null : (bool) $data['in_stock'];

        return new self(
            $data['title'] ?? null,
            $data['sku'] ?? null,
            $data['category'] ?? null,
            $priceMin,
            $priceMax,
            $inStock,
        );
    }

    public function isEmpty(): bool
    {
        return empty(array_filter(get_object_vars($this), fn(mixed $value) => $value !== null));
    }
}
