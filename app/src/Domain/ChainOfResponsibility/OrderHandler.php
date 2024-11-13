<?php

declare(strict_types=1);

namespace App\Domain\ChainOfResponsibility;

use App\Domain\Entity\ProductInterface;

abstract class OrderHandler
{
    public function __construct(private ?OrderHandler $nextHandler = null)
    {
    }

    public function setNext(OrderHandler $nextHandler): OrderHandler
    {
        $this->nextHandler = $nextHandler;
        return $nextHandler;
    }

    public function handleOrder(ProductInterface $product, $ingredients)
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handleOrder($product, $ingredients);
        }
    }
}
