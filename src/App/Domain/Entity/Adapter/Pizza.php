<?php

namespace App\Domain\Entity\Adapter;

use App\Domain\Entity\FoodComposite;

class Pizza extends FoodComposite
{
    public function getChiefSign(): string
    {
        return 'Пицца от шефа ' . $this->name;
    }
}