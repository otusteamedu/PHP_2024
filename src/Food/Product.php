<?php

declare(strict_types=1);

namespace App\Food;

use App\Exception\InvalidArgumentException;
use App\ObjectValue\Money;

class Product implements FoodComponentInterface
{
    private string $name;
    private \SplObjectStorage $ingredients;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->ingredients = new \SplObjectStorage();
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getPrice(): Money
    {
        $amount = 0;
        foreach ($this->ingredients as $ingredient) {
            $amount += $ingredient->getPrice()->getAmount();
        }
        return new Money($amount);
    }

    public function addIngredient(FoodComponentInterface $ingredient): void
    {
        $this->ingredients->attach($ingredient);
    }

    public function removeIngredient(FoodComponentInterface $ingredient): void
    {
        $this->ingredients->detach($ingredient);
    }

    public function getIngredients(): \Iterator
    {
        return $this->ingredients;
    }
}