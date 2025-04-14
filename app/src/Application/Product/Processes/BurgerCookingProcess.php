<?php

namespace AnatolyShilyaev\App\Application\Product\Processes;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

class BurgerCookingProcess extends AbstractCookingProcess
{
    protected function beforeCook(Product $product): void
    {
        echo "[PRE] Начинаем готовку бургера: {$product->getName()}" . PHP_EOL;
    }

    protected function afterCook(Product $product): void
    {
        echo "[POST] Готовка завершена: {$product->getName()}, статус: {$product->getStatus()->value}" . PHP_EOL;
    }

    protected function isValid(Product $product): bool
    {
        // Простая проверка: есть ли котлета
        return in_array('meat', $product->getIngredients());
    }
}
