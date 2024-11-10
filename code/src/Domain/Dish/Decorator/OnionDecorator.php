<?php

declare(strict_types=1);

namespace Irayu\Hw16\Domain\Dish\Decorator;

use Irayu\Hw16\Domain\Dish\Decorator;

class OnionDecorator extends Decorator\BaseDecorator
{
    public function getDescription(): string
    {
         return $this->dish->getDescription() . ", с луком";
    }
}
