<?php

declare(strict_types=1);

namespace Domain\Decorators\Ingredients;

use Domain\Decorators\ProductDecorator;

class SausageDecorator extends ProductDecorator
{
    public function getDescription(): string
    {
        return parent::getDescription() . ', Sausage';
    }
}
