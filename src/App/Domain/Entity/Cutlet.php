<?php

namespace App\Domain\Entity;

class Cutlet extends FoodElement
{
    function getComposite(): string
    {
        return $this->name;
    }
}