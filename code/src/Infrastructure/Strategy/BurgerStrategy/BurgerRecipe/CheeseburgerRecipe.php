<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

class CheeseburgerRecipe extends AbstractBurger
{
    private ?array $ingredients;

    public function __construct()
    {
        $this->ingredients = [
            'маринованный огурец',
            'сыр',
            'бургерный соус',
            'говяжья котлета'
        ];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleBurger();
    }

    protected function assembleBurger(): void
    {
        foreach ($this->ingredients as $ingredients) {
            $this->recipe.= $ingredients.', ';
        }
    }
}