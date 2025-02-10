<?php

declare(strict_types=1);

namespace Domain\ResponsibilityChains;

class PreparationHandler extends ProductCookingHandler
{
    public function handle(string $status): void
    {
        if ($status === 'preparing') {
            echo 'Product is being prepared...' . PHP_EOL;
        } else {
            parent::handle($status);
        }
    }
}
