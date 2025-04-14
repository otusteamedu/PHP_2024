<?php

namespace AnatolyShilyaev\App\Domain\Product\Interfaces;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

interface ProductHandlerInterface
{
    public function setNext(ProductHandlerInterface $handler): ProductHandlerInterface;
    public function handle(string $type): ?Product;
}
