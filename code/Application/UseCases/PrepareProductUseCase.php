<?php

declare(strict_types=1);

namespace Application\UseCases;

use Domain\ChainOfResponsibility\StatusHandlerInterface;
use Domain\Decorators\OnionDecorator;
use Domain\Decorators\SaladDecorator;
use Domain\Entities\Product;
use Domain\Strategies\ProductStrategyInterface;

class PrepareProductUseCase
{
    private ProductStrategyInterface $strategy;
    private StatusHandlerInterface $statusHandler;

    public function __construct(ProductStrategyInterface $strategy, StatusHandlerInterface $statusHandler)
    {
        $this->strategy = $strategy;
        $this->statusHandler = $statusHandler;
    }

    public function prepareProduct(string $ingredients): Product
    {
        $ingredients = explode(',', $ingredients);

        $product = $this->strategy->createProduct();
        $this->statusHandler->handle($product);

        foreach ($ingredients as $ingredient) {
            $product = $this->decorateProduct($product, $ingredient);
        }

        return $product;
    }

    private function decorateProduct($product, string $ingredient): Product
    {
        return match ($ingredient) {
            'onion' => new OnionDecorator($product),
            'pepper' => new SaladDecorator($product),
            default => $product,
        };
    }
}
