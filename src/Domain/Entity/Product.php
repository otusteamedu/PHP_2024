<?php

namespace App\Domain\Entity;

class Product extends AbstractEntity
{
    private string $id;

    private string $title;

    private string $sku;

    private string $category;

    private int $price;

    private float $volume;

    public function __construct(
        string $id,
        string $title,
        string $sku,
        string $category,
        int $price,
        float $volume,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->sku = $sku;
        $this->category = $category;
        $this->price = $price;
        $this->volume = $volume;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): void
    {
        $this->volume = $volume;
    }
}
