<?php

namespace Ahar\Hw16\strategy;

class ConcreteStrategyMultiply implements Strategy
{
    public function doOperation(int $num1, int $num2): int
    {
        return $num1 * $num2;
    }
}
