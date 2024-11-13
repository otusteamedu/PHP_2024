<?php

declare(strict_types=1);

namespace App\Domain\Entity\Food;

use App\Domain\Entity\Food\FoodInterface;

class Hotdog implements FoodInterface, ProductInterface
{
    public function getName(): string
    {
        return 'Burger';
    }
}
