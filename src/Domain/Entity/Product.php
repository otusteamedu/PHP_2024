<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Product
{
    private string $id;
    private string $title;
    private string $category;
    private int $price;
    private int $stock;

    public function __construct(string $title, string $category, int $price, int $stock)
    {
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}