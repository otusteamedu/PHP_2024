<?php

declare(strict_types=1);

namespace Domain\ChainOfResponsibility;

use Domain\Entities\Product;

abstract class AbstractStatusHandler implements StatusHandlerInterface
{
    private ?StatusHandlerInterface $nextHandler = null;

    public function setNext(StatusHandlerInterface $handler): StatusHandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(Product $product): void
    {
        $this->nextHandler?->handle($product);
    }
}
