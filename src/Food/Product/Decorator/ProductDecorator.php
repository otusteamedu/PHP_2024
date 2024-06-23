<?php

declare(strict_types=1);

namespace App\Food\Product\Decorator;

use App\Exception\InvalidArgumentException;
use App\Food\FoodComponentInterface;
use App\Food\Ingredient;
use App\Food\Product\Composite\ProductInterface;
use App\Food\Product\Proxy\ProductProxy;
use App\ObjectValue\Money;

class ProductDecorator extends ProductProxy
{
    /** @var FoodComponentInterface[] */
    protected array $additionIngredients = [];
    public function __construct(protected readonly ProductInterface $product)
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getPrice(): Money
    {
        $ingredientsAmount = array_reduce(
            $this->additionIngredients,
            static fn (int $amount, Ingredient $ingredient) => $amount + $ingredient->getPrice()->getAmount(),
            0
        );
        return new Money($ingredientsAmount + $this->product->getPrice()->getAmount());
    }

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function addAdditionIngredient(FoodComponentInterface $ingredient): self
    {
        $this->additionIngredients[] = $ingredient;
        return $this;
    }
}
