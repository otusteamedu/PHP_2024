<?php

namespace AnatolyShilyaev\App\Infrastructure\Factory;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Interfaces\IngredientDecoratorFactoryInterface;
use AnatolyShilyaev\App\Infrastructure\Factory\Ingredients\{Lettuce, Onion, Pepper};

class IngredientDecoratorFactory implements IngredientDecoratorFactoryInterface
{
    public function decorate(Product $product, string $ingredient): Product
    {
        return match ($ingredient) {
            'lettuce' => new Lettuce($product),
            'onion' => new Onion($product),
            'pepper' => new Pepper($product),
            default => $product, // либо можно бросать исключение
        };
    }
}
