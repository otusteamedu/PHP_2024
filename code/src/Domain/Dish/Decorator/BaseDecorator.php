<?php

declare(strict_types=1);

namespace Irayu\Hw16\Domain\Dish\Decorator;

use Irayu\Hw16\Domain\Dish\Dish;

abstract class BaseDecorator implements Dish
{
    public function __construct(protected Dish $dish)
    {
    }

    abstract public function getDescription(): string;
}
