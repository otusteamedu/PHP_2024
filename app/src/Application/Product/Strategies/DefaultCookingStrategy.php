<?php

namespace AnatolyShilyaev\App\Application\Product\Strategies;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Application\Product\Processes\AbstractCookingProcess;
use AnatolyShilyaev\App\Application\Product\Processes\BurgerCookingProcess;
use AnatolyShilyaev\App\Application\Product\Processes\HotDogCookingProcess;
use AnatolyShilyaev\App\Application\Product\Processes\SandwichCookingProcess;

class DefaultCookingStrategy implements CookingStrategyInterface
{
    public function getCookingProcess(Product $product): AbstractCookingProcess
    {
        return match (get_class($product)) {
            \AnatolyShilyaev\App\Domain\Product\Entity\Types\Burger::class => new BurgerCookingProcess(),
            \AnatolyShilyaev\App\Domain\Product\Entity\Types\HotDog::class => new HotDogCookingProcess(),
            \AnatolyShilyaev\App\Domain\Product\Entity\Types\Sandwich::class => new SandwichCookingProcess(),
            default => throw new \InvalidArgumentException('Неизвестный тип продукта'),
        };
    }
}
