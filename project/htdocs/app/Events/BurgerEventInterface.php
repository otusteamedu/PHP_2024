<?php
namespace App\Events;

use App\Burger;

interface BurgerEventInterface
{
    public function preProcess(Burger $burger): void;
    public function postProcess(Burger $burger): void;
}