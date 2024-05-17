<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product\ProxyStrategyProduct;

use App\Layer\Domain\Entity\EntityInterface\CompositeInterface;
use App\Layer\Domain\Entity\EntityInterface\ProductInterface;
use App\Layer\Domain\Entity\Product\StatusProduct\StatusProduct;
use App\Layer\Domain\Entity\Trait\CompositeTrait;
use App\Layer\Domain\Entity\Trait\ProductTrait;

class ProxyProduct implements CompositeInterface
{
    use CompositeTrait;
    use ProductTrait;
    public function __construct(ProductInterface $strategy)
    {
        $this->strategy = $strategy;
        $this->status = StatusProduct::getStatus();
    }
    public function createNewProduct(): void
    {
        $this->beforeCreateProduct();
        $this->strategy->createProduct();
        $this->afterCreateProduct();
    }

    private function beforeCreateProduct(): void
    {
        echo "Подготовка к созданию продукта <br>";
    }

    private function afterCreateProduct(): void
    {
        echo "Проверка на соответствие стандарту <br>";
    }
}
