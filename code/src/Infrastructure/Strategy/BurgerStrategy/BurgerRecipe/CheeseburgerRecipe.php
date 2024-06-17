<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

class CheeseburgerRecipe extends AbstractBurger
{
    private ?array $ingredient;

    public function __construct()
    {
        $this->ingredient = [
            'маринованный огурец',
            'сыр',
            'бургерный соус',
            'говяжья котлета'
        ];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleBurger($this->ingredient);
    }

}