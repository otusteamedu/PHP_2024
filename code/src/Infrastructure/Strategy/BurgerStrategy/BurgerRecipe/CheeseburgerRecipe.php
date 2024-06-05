<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

class CheeseburgerRecipe extends BurgerBase
{
    private ?array $ingredients;

    private function __construct()
    {
        $this->ingredients = [
            'маринованный огурец',
            'сыр',
            'бургерный соус',
            'говяжья котлета'
        ];
    }

    public function __invoke(): string
    {
        return $this->assembleBurger();
    }

    protected function assembleBurger(): string
    {
        foreach ($this->ingredients as $ingredients) {
            $this->recipe.= $ingredients.', ';
        }
        return $this->recipe;
    }
}