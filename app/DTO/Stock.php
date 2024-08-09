<?php

namespace App\DTO;

readonly class Stock
{
    public string $shop;
    public int $quantity;

    public function __construct(string $shop, int $quantity)
    {
        $this->shop = $shop;
        $this->quantity = $quantity;
    }
}
