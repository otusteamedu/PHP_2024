<?php

namespace AnatolyShilyaev\App\Domain\Product\Services;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Enums\ProductStatus;
use AnatolyShilyaev\App\Domain\Product\Services\ProductStatusNotifier;

class ProductStatusService
{
    public function __construct(
        private ProductStatusNotifier $notifier
    ) {}

    public function changeStatus(Product $product, ProductStatus $status): void
    {
        $product->setStatus($status);
        $this->notifier->notify($product);
    }
}
