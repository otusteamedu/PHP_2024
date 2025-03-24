<?php

namespace App\Domain\Entity;

class Salad extends FoodElement
{
    function getComposite(): string
    {
        return $this->name;
    }
}