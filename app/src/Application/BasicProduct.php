<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\AbstractDecorator;
use App\Domain\Entity\Ingredients\IngredientInterface;

class BasicProduct extends AbstractDecorator
{
    protected $ingredients = [];

    public function __construct(IngredientInterface $ingredient)
    {
        $this->addIngredient($ingredient);
    }
}
