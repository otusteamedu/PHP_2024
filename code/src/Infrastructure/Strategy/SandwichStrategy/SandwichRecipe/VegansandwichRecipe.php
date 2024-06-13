<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\SandwichStrategy\SandwichRecipe;

class VegansandwichRecipe extends AbstractSandwich
{
    private ?array $ingredients;

    public function __construct()
    {
        $this->ingredients = [
            'листья салата',
            'сыр',
            'оливковое масло',
            'сыр моцарелла'
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