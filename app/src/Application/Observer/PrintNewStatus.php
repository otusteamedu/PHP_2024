<?php

declare(strict_types=1);

namespace App\Application\Observer;

use App\Application\Observer\SubscriberInterface;
use App\Application\Observer\ProductStatus;

class PrintNewStatus implements SubscriberInterface
{
    public function update(ProductStatus $status): void
    {
        echo $status->getEventName();
        echo PHP_EOL;
    }
}
