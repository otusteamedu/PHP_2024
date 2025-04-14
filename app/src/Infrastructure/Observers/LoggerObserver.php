<?php

namespace AnatolyShilyaev\App\Infrastructure\Observers;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Interfaces\ProductObserverInterface;

class LoggerObserver implements ProductObserverInterface
{
    public function update(Product $product): void
    {
        // Простой лог
        echo "[LOG] Статус продукта '{$product->getName()}' изменён на {$product->getStatus()->value}" . PHP_EOL . "<br>";
    }
}
