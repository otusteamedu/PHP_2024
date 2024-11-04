<?php

declare(strict_types=1);

namespace Domain\Adapters;

use Domain\Entities\Pizza;
use Domain\Entities\Product;

class PizzaAdapter extends Product
{
    public function __construct(private readonly Pizza $pizza)
    {
    }

    public function getDescription(): string
    {
        return $this->pizza->getPizzaDescription();
    }
}
