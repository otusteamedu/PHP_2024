<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product\StatusProduct;

class StatusProductIterator implements StatusProductIteratorInterface
{
    private $statusProducts;
    public function __construct($statusProducts)
    {
        $this->statusProducts = $statusProducts;
    }

    public function nextStatus(): StatusProduct
    {
        return array_shift($this->statusProducts);
    }

    public function hasNextStatus(): bool
    {
        return !empty($this->statusProducts);
    }

    public function notifyStatusChange(): void
    {
        echo "статус изменился: " . $this->statusProducts->name . "<br>";
    }
}
