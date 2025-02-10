<?php

declare(strict_types=1);

namespace Domain\ResponsibilityChains;

class CookingHandlerChain
{
    private PreparationHandler $chain;

    public function __construct()
    {
        $this->chain = new PreparationHandler();
        $cookingHandler = new CookingHandler();
        $this->chain->setNext($cookingHandler);
    }

    public function handle(string $status): void
    {
        $this->chain->handle($status);
    }
}
