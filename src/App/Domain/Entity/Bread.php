<?php

namespace App\Domain\Entity;

class Bread extends FoodElement
{
    function getComposite(): string
    {
        return $this->name;
    }
}