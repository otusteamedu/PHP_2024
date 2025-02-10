<?php

declare(strict_types=1);

namespace Domain\Observers;

use Domain\Observers\ObserverInterface;

class StatusNotifier implements ObserverInterface
{
    public function update(string $status): void
    {
        echo "Status updated: $status" . PHP_EOL;
    }
}