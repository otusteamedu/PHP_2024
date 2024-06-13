<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

class FishburgerRecipe extends AbstractBurger
{
    private ?array $ingredients;

    public function __construct(
        readonly ?string $additional
    )
    {
        $this->ingredients = [
            'листья салата',
            'сыр',
            'майонез',
            'рыбная котлета'
        ];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleBurger($this->ingredients,$this->additional);
    }


}