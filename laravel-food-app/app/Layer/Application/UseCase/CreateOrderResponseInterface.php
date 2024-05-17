<?php

declare(strict_types=1);

namespace App\Layer\Application\UseCase;

use App\Layer\Domain\Entity\Order\Order;

interface CreateOrderResponseInterface
{
    public function getResponse(Order $order): string;
}
