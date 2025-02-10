<?php

declare(strict_types=1);

namespace Domain\Decorators;

abstract class ProductDecorator implements ProductInterface
{
    public function __construct(protected ProductInterface $product)
    {
        //
    }

    public function getDescription(): string
    {
        return $this->product->getDescription();
    }
}
