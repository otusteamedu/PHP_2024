<?php
namespace App\Strategy;

class ClassicBurgerStrategy implements BurgerStrategy
{
    public function getIngredients(): array
    {
        return [
            'bun',
            'beef-patty',
            'lettuce',
            'tomato',
            'sauce'
        ];
    }
}