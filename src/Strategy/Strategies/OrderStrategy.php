<?php

namespace VladimirGrinko\Patterns\Strategy\Strategies;

interface OrderStrategy
{
    public function generateOrder(array $ingredients): string;
}
