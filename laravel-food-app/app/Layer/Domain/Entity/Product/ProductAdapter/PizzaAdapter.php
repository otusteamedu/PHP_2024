<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product\ProductAdapter;

use App\Layer\Domain\Entity\EntityInterface\ProductInterface;
use App\Layer\Domain\Entity\Product\Product;

class PizzaAdapter extends Product
{
    public string $message;
    public function __construct(ProductInterface $strategy = null)
    {
        parent::__construct($strategy);
    }

    public function calcPrice($price = null): void
    {
        $this->price = 0;
        $this->notify();
    }

    private function notify(): string
    {
        $this->message = "Pizza is free!";
        return $this->message;
    }
}
