<?php

declare(strict_types=1);

namespace Infrastructure\DI;

use Application\UseCases\PrepareProductUseCase;
use Domain\ChainOfResponsibility\CookingHandler;
use Domain\ChainOfResponsibility\ReadyHandler;
use Domain\Strategies\BurgerStrategy;
use Domain\Strategies\HotDogStrategy;
use Domain\Strategies\SandwichStrategy;
use Infrastructure\Factories\BurgerFactory;
use Infrastructure\Factories\HotDogFactory;
use Infrastructure\Factories\SandwichFactory;
use InvalidArgumentException;

class Container
{
    public function getPrepareProductUseCase(string $productType): PrepareProductUseCase
    {
        $cookingHandler = (new CookingHandler())
            ->setNext(new ReadyHandler());

        $strategy = match ($productType) {
            'burger' => new BurgerStrategy(new BurgerFactory()),
            'hotdog' => new HotDogStrategy(new HotDogFactory()),
            'sandwich' => new SandwichStrategy(new SandwichFactory()),
            default => throw new InvalidArgumentException('Unknown product type'),
        };

        return new PrepareProductUseCase($strategy, $cookingHandler);
    }
}
