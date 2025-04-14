<?php

namespace AnatolyShilyaev\App\Domain\Product\Services\Chain;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Interfaces\ProductHandlerInterface;

abstract class AbstractProductHandler implements ProductHandlerInterface
{
    protected ?ProductHandlerInterface $next = null;

    public function setNext(ProductHandlerInterface $handler): ProductHandlerInterface
    {
        $this->next = $handler;
        return $handler;
    }

    public function handle(string $type): ?Product
    {
        if ($this->next) {
            return $this->next->handle($type);
        }

        return null;
    }
}
