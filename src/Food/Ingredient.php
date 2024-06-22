<?php

declare(strict_types=1);

namespace App\Food;

use App\ObjectValue\Money;

class Ingredient implements FoodComponentInterface
{
    public function __construct(private string $name, private Money $price)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }
}
