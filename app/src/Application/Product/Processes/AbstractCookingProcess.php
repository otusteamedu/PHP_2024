<?php

namespace AnatolyShilyaev\App\Application\Product\Processes;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Enums\ProductStatus;

abstract class AbstractCookingProcess
{
    public function cook(Product $product): void
    {
        $this->beforeCook($product);

        $product->setStatus(ProductStatus::COOKING);
        // Имитация готовки — может быть заменена реальной логикой
        sleep(1);

        if ($this->isValid($product)) {
            $product->setStatus(ProductStatus::READY);
        } else {
            $this->onFailedCook($product);
            return;
        }

        $this->afterCook($product);
    }

    protected function beforeCook(Product $product): void
    {
        // Пре-событие (можно переопределить)
    }

    protected function afterCook(Product $product): void
    {
        // Пост-событие (например, логгирование, отправка уведомлений)
    }

    protected function onFailedCook(Product $product): void
    {
        $product->setStatus(ProductStatus::DISCARDED);
    }

    abstract protected function isValid(Product $product): bool;
}
