<?php

declare(strict_types=1);

namespace App\Food;

use App\ObjectValue\Money;

interface FoodComponentInterface
{
    public function getName(): string;
    public function getPrice(): Money;
}
