<?php

declare(strict_types=1);

namespace Domain\Decorators\Ingredients;

use Domain\Decorators\ProductDecorator;

class OnionDecorator extends ProductDecorator
{
    public function getDescription(): string
    {
        return parent::getDescription() . ', Onion';
    }
}
