<?php

declare(strict_types=1);

namespace App\Food\Product\Composite;

use App\Exception\InvalidArgumentException;
use App\Food\FoodComponentInterface;
use App\Food\Ingredient;
use App\ObjectValue\Money;

class Product implements ProductInterface
{
    protected string $name;
    protected array $ingredients = [];

    public function __construct(string $name)
    {
        $this->name = $name;
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
        return new Money(
            array_reduce(
                $this->ingredients,
                static fn (int $amount, Ingredient $ingredient) => $amount + $ingredient->getPrice()->getAmount(),
                0
            )
        );
    }

    public function addIngredient(FoodComponentInterface $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    /**
     * @return FoodComponentInterface[]
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}