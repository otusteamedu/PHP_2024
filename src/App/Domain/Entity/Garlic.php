<?php

namespace App\Domain\Entity;

class Garlic extends FoodElement
{
    function getComposite(): string
    {
        return $this->name;
    }
}