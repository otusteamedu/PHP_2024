<?php
namespace App\Domain\Model;

class Product {
    private string $title;
    private string $category;
    private float $price;
    private bool $inStock;

    public function __construct(string $title, string $category, float $price, bool $inStock) {
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->inStock = $inStock;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function isInStock(): bool {
        return $this->inStock;
    }
}
