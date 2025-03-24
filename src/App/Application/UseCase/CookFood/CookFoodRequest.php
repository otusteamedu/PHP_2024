<?php

namespace App\Application\UseCase\CookFood;

use App\Domain\Entity\FoodComposite;

class CookFoodRequest
{
    /**
     * @param FoodComposite $foodComposite
     * @param array $foodAdditives
     */
    public function __construct(public FoodComposite $foodComposite, public array $foodAdditives = [])
    {
    }
}