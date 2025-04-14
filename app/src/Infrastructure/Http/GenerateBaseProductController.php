<?php

namespace AnatolyShilyaev\App\Infrastructure\Http;

use AnatolyShilyaev\App\Application\UseCase\GenerateBaseProductUseCase;
use AnatolyShilyaev\App\Domain\Product\Entity\Product;

class GenerateBaseProductController
{
    public function __construct(
        private GenerateBaseProductUseCase $generateBaseProductUseCase,
    ) {
        // Empty constructor
    }

    public function __invoke(string $type): Product | string
    {
        try {
            $response = ($this->generateBaseProductUseCase)($type);
            return $response;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
