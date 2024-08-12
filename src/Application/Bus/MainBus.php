<?php

declare(strict_types=1);

namespace App\Application\Bus;

use App\Application\Bus\OrderStep\AbstractStep;
use App\Application\DTO\OrderDto;

class MainBus
{
    public function __construct(private readonly AbstractStep $firstStep) {}

    public function execute(OrderDto $order): void
    {
        $this->firstStep->handle($order);
    }
}
