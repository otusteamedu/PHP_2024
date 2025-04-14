<?php

namespace AnatolyShilyaev\App\Application\UseCase;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Application\Product\Strategies\CookingStrategyInterface;

class CookProductUseCase
{
    public function __construct(
        private CookingStrategyInterface $strategy
    ) {}

    public function __invoke(Product $product): void
    {
        $process = $this->strategy->getCookingProcess($product);
        $process->cook($product);
    }
}
