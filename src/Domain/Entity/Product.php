<?php

namespace VSukhov\Hw12\Domain\Entity;

use VSukhov\Hw12\Domain\ValueObject\Category;
use VSukhov\Hw12\Domain\ValueObject\Price;
use VSukhov\Hw12\Domain\ValueObject\Stock;

class Product
{
    public function __construct(
        private string   $id,
        private string   $title,
        private Category $category,
        private Price    $price,
        private Stock    $stock
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getStock(): Stock
    {
        return $this->stock;
    }
}
