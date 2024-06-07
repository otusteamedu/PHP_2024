<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\HotdogStrategy\HotdogRecipe;

class TexashotdogRecipe extends AbstractHotdog
{
    private ?array $ingredients;

    public function __construct()
    {
        $this->ingredients = [
            'маринованный огурец',
            'соус чили',
            'кетчуп',
            'говяжья сосиска'
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