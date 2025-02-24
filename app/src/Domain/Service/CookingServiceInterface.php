<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Service;

use Otus\Hw16\Domain\Entity\FoodItem;

interface CookingServiceInterface
{
    public function cook(FoodItem $foodItem): bool;
}
