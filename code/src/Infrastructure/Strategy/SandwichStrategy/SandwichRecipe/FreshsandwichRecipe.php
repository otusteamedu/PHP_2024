<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\SandwichStrategy\SandwichRecipe;

class FreshsandwichRecipe extends AbstractSandwich
{
    private ?array $ingredients;

    public function __construct()
    {
        $this->ingredients = [
            'листья салата',
            'сыр',
            'майонез',
            'рубленая курица'
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