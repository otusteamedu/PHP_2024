<?php

declare(strict_types=1);

namespace Domain\ResponsibilityChains;

abstract class ProductCookingHandler
{
    private ?ProductCookingHandler $nextHandler;

    public function setNext(?ProductCookingHandler $handler): ProductCookingHandler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(string $status): void
    {
        $this->nextHandler?->handle($status);
    }
}
