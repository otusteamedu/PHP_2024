<?php

declare(strict_types=1);

namespace App\Entity;

class Product
{
    private string $title;
    private string $sku;
    private string $category;
    private int $price;
    private float $volume;
    private array $stock;

    public function __construct()
    {
        $this->stock = [];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Product
    {
        $this->title = $title;

        return $this;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): Product
    {
        $this->sku = $sku;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): Product
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): Product
    {
        $this->price = $price;

        return $this;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): Product
    {
        $this->volume = $volume;

        return $this;
    }

    public function getStock(): ?array
    {
        return $this->stock;
    }

    /**
     * @param Stock[] $stock
     */
    public function setStock(array $stock): Product
    {
        $this->stock = $stock;

        return $this;
    }

    public function __toString(): string
    {
        $str = implode(', ', [$this->title, $this->category, $this->sku, $this->volume, $this->getPrice()]);

        /**
         * @var Stock $stockItem
         */
        foreach ($this->stock as $stockItem) {
            $stocks[] = $stockItem->getShop().' - '.$stockItem->getStock();
        }

        if (!empty($stocks)) {
            $str .= ' Наличие: '.implode(', ', $stocks);
        }

        return $str;
    }
}
