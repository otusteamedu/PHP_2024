<?php

declare(strict_types=1);

namespace App\Domain\Entity\Food;

use App\Domain\Entity\Food\FoodInterface;
use App\Domain\Entity\ProductInterface;

class Burger implements FoodInterface, ProductInterface
{
    public function getName(): string
    {
        return 'Burger';
    }
}
