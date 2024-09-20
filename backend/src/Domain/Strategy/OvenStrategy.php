<?php

declare(strict_types=1);

namespace App\Domain\Strategy;

use App\Domain\Entity\Meal;

class OvenStrategy implements CookingStrategyInterface
{
    public function cook(Meal $meal): void
    {
        echo "Prepare " . $meal->getName() . " on oven...\n";
    }
}
