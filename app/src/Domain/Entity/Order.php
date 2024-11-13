<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\ProductInterface;
use App\Domain\Entity\MethodServing\MethodServingInterface;

class Order
{
    private ProductInterface $product;
    private array $ingredients;
    private MethodServingInterface $methodServing;

    public function __construct(ProductInterface $product, array $ingredients, MethodServingInterface $methodServing)
    {
        $this->product = $product;
        $this->ingredients = $ingredients;
        $this->methodServing = $methodServing;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function getMethodServing(): MethodServingInterface
    {
        return $this->methodServing;
    }
}
