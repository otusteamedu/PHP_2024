<?php

namespace App\Application\Composite;

use App\Domain\Entity\FoodComposite;
use App\Domain\Entity\FoodElement;

class FoodCompositeRequest
{
    /**
     * @param FoodComposite $foodComposite
     * @param FoodElement[] $foodAdditives
     */
    public function __construct(public FoodComposite $foodComposite, public array $foodAdditives)
    {
    }
}