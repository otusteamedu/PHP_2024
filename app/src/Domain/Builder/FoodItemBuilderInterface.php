<?php

namespace Otus\Hw16\Domain\Builder;

use Otus\Hw16\Domain\Entity\FoodItem;

interface FoodItemBuilderInterface
{
    public function setBase(): self;
    public function getProduct(): FoodItem;
}
