<?php

declare(strict_types=1);

namespace App\Domain\Entity\Ingredients;

use App\Domain\Entity\Ingredients\IngredientInterface;

class Cheese implements IngredientInterface
{
    public function getName(): string
    {
        return 'Cheese';
    }
}
