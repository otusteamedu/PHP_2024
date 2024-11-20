<?php

declare(strict_types=1);

namespace Afilipov\Hw16\adapter;

class Pizza implements IPizza
{
    public function preparePizza(): void
    {
        echo "Приготовление пиццы\n";
    }
}
