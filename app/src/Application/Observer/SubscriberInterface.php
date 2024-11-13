<?php

declare(strict_types=1);

namespace App\Application\Observer;

use App\Application\Observer\ProductStatus;

//интерфейс для Наблюдателей
interface SubscriberInterface
{
    public function update(ProductStatus $event): void;
}
