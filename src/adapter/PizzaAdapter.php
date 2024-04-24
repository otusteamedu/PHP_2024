<?php

declare(strict_types=1);

namespace Afilipov\Hw16\adapter;

readonly class PizzaAdapter implements IFoodItem
{
    public function __construct(private IPizza $pizza)
    {
    }

    public function prepareFood(): void
    {
        $this->pizza->preparePizza();
    }
}
