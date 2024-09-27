<?php

declare(strict_types=1);

namespace Afilipov\Hw16\composite;

class BaseProduct implements IProduct
{
    public function prepare(): void
    {
        echo "Приготовление базового рецепта\n";
    }
}
