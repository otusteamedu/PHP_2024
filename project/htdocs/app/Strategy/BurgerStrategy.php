<?php
namespace App\Strategy;

interface BurgerStrategy
{
    public function getIngredients(): array;
}