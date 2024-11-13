<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\Order;

interface CookingOrderInterface
{
    public function processCooking(Order $order): void;
}
