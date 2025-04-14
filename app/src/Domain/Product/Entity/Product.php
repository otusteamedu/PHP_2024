<?php

namespace AnatolyShilyaev\App\Domain\Product\Entity;

use AnatolyShilyaev\App\Domain\Product\Enums\ProductStatus;

abstract class Product
{
    protected string $name;
    protected float $price = 0;
    protected ProductStatus $status = ProductStatus::CREATED;
    protected array $ingredients = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function getStatus(): ProductStatus
    {
        return $this->status;
    }

    public function setStatus(ProductStatus $status): void
    {
        $this->status = $status;
    }

    public function addIngredient(string $ingredient, float $cost): void
    {
        $this->ingredients[] = $ingredient;
        $this->price += $cost;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'status' => $this->getStatus(),
            'ingredients' => $this->getIngredients(),
        ];
    }
}
