<?php

namespace AnatolyShilyaev\App\Application\UseCase;

use AnatolyShilyaev\App\Domain\Product\Interfaces\ProductHandlerInterface;
use AnatolyShilyaev\App\Domain\Product\Entity\Product;

class GenerateBaseProductUseCase
{
    public function __construct(
        private readonly ProductHandlerInterface $productHandlerChain
    ) {
        // Empty
    }

    public function __invoke(string $type): ?Product
    {
        return $this->productHandlerChain->handle($type);
    }
}
