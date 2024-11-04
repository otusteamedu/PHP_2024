<?php

declare(strict_types=1);

namespace Infrastructure\Controllers;

use Exception;
use http\Exception\RuntimeException;
use Infrastructure\DI\Container;

class CreateProductConsoleController
{
    public function __construct(private readonly Container $container)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(string $productType, ?string $ingredients): void
    {
        if (!in_array($productType, ['burger', 'hotdog', 'sandwich'])) {
            throw new Exception("Invalid product type!");
        }

        try {
            $useCase = $this->container->getPrepareProductUseCase($productType);
            $product = $useCase->prepareProduct($ingredients);
        } catch (Exception $e) {
            throw new RuntimeException('Error: ' . $e->getMessage());
        }

        echo "Product successfully prepared: " . $product->getDescription();
    }
}
