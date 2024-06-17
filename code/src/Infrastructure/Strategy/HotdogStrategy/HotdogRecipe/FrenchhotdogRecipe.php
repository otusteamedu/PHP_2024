<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\HotdogStrategy\HotdogRecipe;

class FrenchhotdogRecipe extends AbstractHotdog
{
    private ?array $ingredient;

    public function __construct()
    {
        $this->ingredient = [
            'маринованный огурец',
            'соус рейлиш',
            'кетчуп',
            'говяжья сосиска с беконом'
        ];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleHotdog($this->ingredient);
    }

}