<?php

namespace App\Domain\Entity\Adapter;

use App\Domain\Entity\Burger;

class Adapter extends Burger
{
    public function __construct(private Pizza $pizza)
    {
        parent::__construct($this->pizza->name);
    }

    public function composite(): string
    {
        $composite = parent::getComposite();

        return  $this->pizza->getChiefSign() . ' (' . $composite . ')';
    }
}