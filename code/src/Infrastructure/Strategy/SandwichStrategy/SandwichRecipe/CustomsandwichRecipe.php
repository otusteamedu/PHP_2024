<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\SandwichStrategy\SandwichRecipe;

use App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe\AbstractBurger;

class CustomsandwichRecipe extends AbstractBurger
{
    private ?array $ingredients;

    public function __construct()
    {
        $this->ingredients = [];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleBurger($this->ingredients);
    }

}