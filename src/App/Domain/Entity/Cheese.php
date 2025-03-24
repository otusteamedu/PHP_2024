<?php

namespace App\Domain\Entity;

class Cheese extends FoodElement
{
    function getComposite(): string
    {
        return $this->name;
    }
}