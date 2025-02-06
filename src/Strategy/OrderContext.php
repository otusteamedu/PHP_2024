<?php

namespace VladimirGrinko\Patterns\Strategy;

use VladimirGrinko\Patterns\Strategy\Strategies\OrderStrategy;

class OrderContext
{
    private OrderStrategy $strategy;

    public function setStrategy(OrderStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function createOrder(array $ingredients): string
    {
        if (!isset($this->strategy)) {
            throw new \Exception("Стратегия не установлена");
        }
        return $this->strategy->generateOrder($ingredients);
    }
}
