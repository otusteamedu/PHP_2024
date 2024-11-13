<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Entity\ProductInterface;
use App\Domain\Entity\Ingredients\IngredientInterface;

abstract class AbstractDecorator implements ProductInterface
{
    protected $product;
    protected $ingredients = [];

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function addIngredient(IngredientInterface ...$ingredients): ProductInterface
    {
        $this->ingredients = array_merge($this->getIngredients(), $ingredients);
        return $this;
    }

    public function getIngredients(): array
    {
        if ($this->product) {
            return $this->product->ingredients;
        } else {
            return [];
        }
    }
}
