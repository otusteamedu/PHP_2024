<?php

declare(strict_types=1);

namespace App\Entity;

class Stock
{
    private string $shop;
    private int $stock;

    public function getShop(): string
    {
        return $this->shop;
    }

    public function setShop(string $shop): Stock
    {
        $this->shop = $shop;

        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): Stock
    {
        $this->stock = $stock;

        return $this;
    }
}
