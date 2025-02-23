<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Repository;

use Otus\Hw16\Domain\Entity\FoodItem;
use Otus\Hw16\Domain\Entity\OrderStatusHistory;

interface FoodItemRepositoryInterface
{
    public function save(FoodItem $foodItem): int;

    public function saveStatusHistory(OrderStatusHistory $history): void;
}
