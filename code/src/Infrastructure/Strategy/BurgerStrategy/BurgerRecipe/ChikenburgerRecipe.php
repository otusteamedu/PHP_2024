<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

class ChikenburgerRecipe extends AbstractBurger
{
    private ?array $ingredient;

    public function __construct(
        readonly ?string $additional
    )
    {
        $this->ingredient = [
            'листья салата',
            'сыр',
            'рейлиш соус',
            'гуриная грудка'
        ];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleBurger($this->ingredient,$this->additional);
    }
}