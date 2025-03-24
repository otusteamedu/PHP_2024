<?php

namespace App\Application\Strategy;

use App\Domain\Entity\FoodComposite;

class Context
{
    private Strategy $strategy;

    public function setStrategy(Strategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function executeStrategy(): FoodComposite
    {
        return $this->strategy->generateNewFood();
    }
}