<?php

declare(strict_types=1);

namespace Domain\ResponsibilityChains;

class CookingHandler extends ProductCookingHandler
{
    public function handle(string $status): void
    {
        if ($status === 'cooking') {
            echo 'Product is cooking...' . PHP_EOL;
        } else {
            parent::handle($status);
        }
    }
}
