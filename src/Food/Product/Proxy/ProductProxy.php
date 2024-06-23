<?php

declare(strict_types=1);

namespace App\Food\Product\Proxy;

use App\Exception\InvalidArgumentException;
use App\Food\FoodComponentInterface;
use App\Food\Product\Composite\Product;
use App\Food\Product\Composite\ProductInterface;
use App\ObjectValue\Money;

class ProductProxy implements ProductInterface
{
    private Product $product;
    public function __construct(string $name)
    {
        $this->product = new Product($name);
        echo "Готовим: {$this->product->getName()}\n";
        sleep(1);
    }

    public function getName(): string
    {
        return $this->product->getName();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getPrice(): Money
    {
        return $this->product->getPrice();
    }

    public function addIngredient(FoodComponentInterface $ingredient): void
    {
        echo "Добавляем ингредиент: {$ingredient->getName()}\n";
        $this->product->addIngredient($ingredient);
        sleep(1);
    }

    public function getIngredients(): array
    {
       return $this->product->getIngredients();
    }
}
