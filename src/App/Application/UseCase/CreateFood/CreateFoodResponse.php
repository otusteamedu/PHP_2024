<?php

namespace App\Application\UseCase\CreateFood;

use App\Domain\Entity\FoodComposite;

class CreateFoodResponse
{
    public function __construct(public FoodComposite $food)
    {
    }
}