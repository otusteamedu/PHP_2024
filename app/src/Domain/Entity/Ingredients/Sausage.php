<?php

declare(strict_types=1);

namespace App\Domain\Entity\Ingredients;

use App\Domain\Entity\Ingredients\IngredientInterface;

class Sausage implements IngredientInterface
{
    public function getName(): string
    {
        return 'Sausage';
    }
}
