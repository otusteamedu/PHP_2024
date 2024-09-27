<?php

declare(strict_types=1);

namespace Afilipov\Hw16\iterator;

class NotificationService implements IObserver
{
    public function update(ProductStatus $status): void
    {
        echo "Статус изменён: {$status->value}.\n";
    }
}
