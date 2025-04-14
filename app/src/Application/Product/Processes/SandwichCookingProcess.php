<?php

namespace AnatolyShilyaev\App\Application\Product\Processes;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

class SandwichCookingProcess extends AbstractCookingProcess
{
    protected function beforeCook(Product $product): void
    {
        echo "[PRE] Подготовка сэндвича: {$product->getName()}\n";
    }

    protected function afterCook(Product $product): void
    {
        echo "[POST] Готовка завершена: {$product->getName()}, статус: {$product->getStatus()->value}" . PHP_EOL;
    }

    protected function isValid(Product $product): bool
    {
        // Простая проверка: есть ли хлеб
        return in_array('bread', $product->getIngredients());
    }
}
