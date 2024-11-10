<?php

declare(strict_types=1);

namespace Irayu\Hw16\Infrastructure\Dish\Decorator;

use Irayu\Hw16\Domain\Dish\Decorator;

class QualityDecorator extends Decorator\BaseDecorator
{
    public function getDescription(): string
    {
         return $this->dish->getDescription() . " с повышенным качеством";
    }
}
