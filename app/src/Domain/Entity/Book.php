<?php

declare(strict_types=1);

namespace Kagirova\Hw14\Domain\Entity;

class Book
{
    public function __construct(
        private int $id,
        private string $title,
        private string $category,
        private int $price,
        private string $stock
    ) {
    }

    public function getId(): int
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

    public function getStock(): string
    {
        return $this->stock;
    }
}
