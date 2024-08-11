<?php

declare(strict_types=1);

namespace App\Domain\Ingredient;

use App\Domain\Product\{CanCookProductInterface, HasCompositionInterface};

abstract class AbstractDecorator implements CanCookProductInterface
{
    abstract public function getProduct(): HasCompositionInterface;
}
