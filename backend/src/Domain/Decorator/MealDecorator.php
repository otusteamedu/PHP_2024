<?php

declare(strict_types=1);

namespace App\Domain\Decorator;

use App\Domain\Entity\Meal;

abstract class MealDecorator implements Meal
{
    public function __construct(protected Meal $meal)
    {
    }

    public function getName(): string
    {
        return $this->meal->getName();
    }

    public function prepare(): void
    {
        $this->meal->prepare();
    }
}
