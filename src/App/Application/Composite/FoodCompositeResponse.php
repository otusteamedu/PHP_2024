<?php

namespace App\Application\Composite;

use App\Domain\Entity\FoodComposite;

class FoodCompositeResponse
{
    public function __construct(public FoodComposite $foodComposite)
    {
    }
}