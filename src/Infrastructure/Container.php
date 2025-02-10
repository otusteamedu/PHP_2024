<?php

declare(strict_types=1);

namespace Infrastructure;

use Domain\Observers\StatusNotifier;
use Domain\ResponsibilityChains\CookingHandlerChain;
use Domain\Strategies\BurgerStrategy;
use Domain\Strategies\HotDogStrategy;
use Domain\Strategies\ProductStrategyInterface;
use Domain\Strategies\SandwichStrategy;

class Container
{
    private array $instances = [];

    /**
     * @throws \InvalidArgumentException
     */
    public function get($key)
    {
        if (!isset($this->instances[$key])) {
            $this->instances[$key] = $this->createInstance($key);
        }

        return $this->instances[$key];
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function createInstance($key): ProductStrategyInterface|StatusNotifier|CookingHandlerChain
    {
        return match ($key) {
            'Burger' => new BurgerStrategy(),
            'Sandwich' => new SandwichStrategy(),
            'HotDog' => new HotDogStrategy(),
            'StatusNotifier' => new StatusNotifier(),
            'CookingHandlerChain' => new CookingHandlerChain(),
            default => throw new \InvalidArgumentException("Unknown key: $key"),
        };
    }
}
