<?php

declare(strict_types=1);

namespace App\Application\ChainOfResponsibility;

use App\Domain\ChainOfResponsibility\OrderHandler;
use App\Domain\Entity\ProductInterface;
use App\Application\WorkWithIngredients;

class SandwichHandler extends OrderHandler
{
    public function handleOrder(ProductInterface $product, $ingredients)
    {
        if (strtolower($product->getName()) === 'sandwich') {
            echo "Готовим СЭНДВИЧ" . PHP_EOL;
            $readyProduct = (new WorkWithIngredients())->cook($product, $ingredients);
            return $readyProduct;
        } else {
            return parent::handleOrder($product, $ingredients);
        }
    }
}
