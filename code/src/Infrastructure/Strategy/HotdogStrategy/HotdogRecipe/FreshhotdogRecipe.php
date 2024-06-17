<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\HotdogStrategy\HotdogRecipe;

class FreshhotdogRecipe extends AbstractHotdog
{
    private ?array $ingredient;

    public function __construct()
    {
        $this->ingredient = [
            'маринованный огурец',
            'горчица',
            'кетчуп',
            'куриная сосиска',
            'листья салата'
        ];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleHotdog($this->ingredient);
    }

}