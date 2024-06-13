<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\SandwichStrategy\SandwichRecipe;

class AmericansandwichRecipe extends AbstractSandwich
{
    private ?array $ingredients;

    public function __construct()
    {
        $this->ingredients = [
            'луковые кольца',
            'сыр',
            'соус для сэндвичей',
            'рубленая говядина'
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