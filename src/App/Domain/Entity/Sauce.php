<?php

namespace App\Domain\Entity;

class Sauce extends FoodComposite
{
    public function getComposite(): string
    {
        $composite = parent::getComposite();

        return '(' . $this->name . ': ' . $composite . ')';
    }
}