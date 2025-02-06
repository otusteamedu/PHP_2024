<?php

namespace VladimirGrinko\Patterns\Strategy\Strategies;

class BurgerStrategy implements OrderStrategy
{
    public function generateOrder(array $ingredients): string
    {
        return "Сэндвич создан с такими ингридиентами: " . implode(", ", $ingredients);
    }
}
