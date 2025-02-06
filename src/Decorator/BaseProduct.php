<?php

namespace VladimirGrinko\Patterns\Decorator;

class BaseProduct implements ProductInterface
{
    private string $name;
    private float $cost;

    public function __construct(string $name, float $cost)
    {
        $this->name = $name;
        $this->cost = $cost;
    }

    public function getDescription(): string
    {
        return $this->name;
    }

    public function getCost(): float
    {
        return $this->cost;
    }
}
