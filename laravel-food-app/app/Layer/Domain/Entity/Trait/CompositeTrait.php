<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Trait;

use App\Layer\Domain\Entity\EntityInterface\CompositeItemInterface;
use App\Layer\Domain\Entity\Product\Product;
use App\Layer\Domain\Entity\Product\ProxyStrategyProduct\ProxyProduct;

trait CompositeTrait
{
    public array $compositeItems = [];

    public function setChildItem(CompositeItemInterface $item): void
    {
        $this->compositeItems[] = $item;
    }

    public function calcPrice($price = null)
    {
        if ($this->price) return $this->price;

        $this->price = 0;

        if ($this instanceof Product || $this instanceof ProxyProduct) {
            foreach ($this->strategy->compositeItems as $compositeItem) {
                $this->price += $compositeItem->price;
            }
        }

        foreach ($this->compositeItems as $compositeItem) {

            $this->price += $compositeItem->calcPrice();
        }

        return $this->price;
    }
}
