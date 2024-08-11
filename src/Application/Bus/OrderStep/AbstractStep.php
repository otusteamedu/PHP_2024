<?php

declare(strict_types=1);

namespace App\Application\Bus\OrderStep;

use App\Application\DTO\OrderDto;

abstract class AbstractStep
{
    public function __construct(private ?AbstractStep $nextStep = null) {}

    public function setNext(AbstractStep $step): AbstractStep
    {
        $this->nextStep = $step;

        return $step;
    }

    public function handle(OrderDto $order): void
    {
        $this->nextStep?->handle($order);
    }
}
