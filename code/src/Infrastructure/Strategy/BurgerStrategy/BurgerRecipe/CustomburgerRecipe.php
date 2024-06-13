<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

class CustomburgerRecipe extends AbstractBurger
{
    private ?array $ingredients;

    public function __construct(
        readonly ?string $additional
    )
    {
        $this->ingredients = [];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleBurger($this->ingredients,$this->additional);
    }

}