<?php

namespace VladimirGrinko\Patterns\Decorator;

interface ProductInterface
{
    public function getDescription(): string;
    public function getCost(): float;
}
