<?php

namespace App\Domain\Entity;

class Hotdog extends FoodComposite
{
    public function getComposite(): string
    {
        $composite = parent::getComposite();

        return $this->name . ' (' . $composite . ')';
    }
}