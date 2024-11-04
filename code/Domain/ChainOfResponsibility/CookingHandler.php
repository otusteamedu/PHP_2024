<?php

declare(strict_types=1);

namespace Domain\ChainOfResponsibility;

use Domain\Entities\Product;

class CookingHandler extends AbstractStatusHandler
{
    public function handle(Product $product): void
    {
        echo "Product is cooking...\n";
        parent::handle($product);
    }
}
