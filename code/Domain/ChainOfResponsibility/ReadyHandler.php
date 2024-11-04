<?php

declare(strict_types=1);

namespace Domain\ChainOfResponsibility;

use Domain\Entities\Product;

class ReadyHandler extends AbstractStatusHandler
{
    public function handle(Product $product): void
    {
        echo "Product is ready!\n";
        parent::handle($product);
    }
}
