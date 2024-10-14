<?php

declare(strict_types=1);

namespace App\Shop\Model;

final readonly class Stock
{
    public function __construct(
        public string $shop,
        public int $stock,
    ) {}
}