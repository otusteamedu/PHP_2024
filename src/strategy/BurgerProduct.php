<?php

declare(strict_types=1);

namespace Afilipov\Hw16\strategy;

class BurgerProduct implements IProduct
{
    public function generateProduct(): string
    {
        return "Генерация бургера";
    }
}
