<?php

namespace AnatolyShilyaev\App\Application\Product\Processes;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

class HotDogCookingProcess extends AbstractCookingProcess
{
    protected function beforeCook(Product $product): void
    {
        // Пример пре-процесса: логируем
        echo "[PRE] Подготовка хот-дога: {$product->getName()}\n";
    }

    protected function afterCook(Product $product): void
    {
        // Пример пост-процесса
        echo "[POST] Готовка завершена: {$product->getName()}, статус: {$product->getStatus()->value}" . PHP_EOL;
    }

    protected function isValid(Product $product): bool
    {
        // Простая проверка: есть ли сосиска
        return in_array('sausage', $product->getIngredients());
    }
}
