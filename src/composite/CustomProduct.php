<?php

declare(strict_types=1);

namespace Afilipov\Hw16\composite;

readonly class CustomProduct implements IProduct
{
    public function __construct(private string $name)
    {
    }

    public function prepare(): void
    {
        echo "Добавляем $this->name\n";
    }
}
