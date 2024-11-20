<?php

declare(strict_types=1);

namespace Afilipov\Hw16\proxy;

class Burger implements IFood
{
    public function cook(): void
    {
        echo "Готовим бургер\n";
    }
}
