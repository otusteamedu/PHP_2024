<?php

declare(strict_types=1);

namespace App\Domain\Strategy;

class GrillStrategy implements CookingStategyInterface
{
    public function cook(Meal $meal): void
    {
        echo "Готовим " . $meal->getName() . " на гриле...\n";
    }
}