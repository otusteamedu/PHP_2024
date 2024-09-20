<?php

declare(strict_types=1);

namespace App\Domain\Strategy;

use App\Domain\Entity\Meal;

interface CookingStrategyInterface
{
    public function cook(Meal $meal): void;
}
