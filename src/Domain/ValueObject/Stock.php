<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Stock
{
    private string $shop;
    private int $stock;

    public function __construct(string $shop, int $stock)
    {
        $this->shop = $shop;
        $this->stock = $stock;
    }

    public function getShop(): string
    {
        return $this->shop;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function equals(Stock $other): bool
    {
        return $this->shop === $other->shop && $this->stock === $other->stock;
    }

    public function __toString()
    {
        return $this->shop . ': ' . $this->stock;
    }
}
