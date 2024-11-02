<?php

declare(strict_types=1);

namespace Domain\ChainOfResponsibility;

use Domain\Entities\Product;

interface StatusHandlerInterface
{
    public function setNext(StatusHandlerInterface $handler): StatusHandlerInterface;
    public function handle(Product $product): void;
}
