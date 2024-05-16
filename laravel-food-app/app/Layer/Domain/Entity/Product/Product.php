<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product;

use App\Layer\Domain\Entity\EntityInterface\CompositeInterface;
use App\Layer\Domain\Entity\EntityInterface\ProductInterface;
use App\Layer\Domain\Entity\Product\StatusProduct\StatusProduct;
use App\Layer\Domain\Entity\Trait\CompositeTrait;
use App\Layer\Domain\Entity\Trait\ProductTrait;

class Product implements CompositeInterface
{
    use CompositeTrait;
    use ProductTrait;

    public function __construct(ProductInterface $strategy = null)
    {
        $this->strategy = $strategy;
        $this->status = StatusProduct::getStatus();
    }
}
