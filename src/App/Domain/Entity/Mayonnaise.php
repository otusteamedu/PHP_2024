<?php

namespace App\Domain\Entity;

class Mayonnaise extends FoodElement
{
    function getComposite(): string
    {
        return $this->name;
    }
}