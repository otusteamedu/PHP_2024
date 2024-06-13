<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\HotdogStrategy\HotdogRecipe;

class TexashotdogRecipe extends AbstractHotdog
{
    private ?array $ingredient;

    public function __construct(
        readonly ?string $additional
    )
    {
        $this->ingredient = [
            'маринованный огурец',
            'соус чили',
            'кетчуп',
            'говяжья сосиска'
        ];
        $this->assign();
    }

    private function assign(): void
    {
        $this->assembleHotdog($this->ingredient,$this->additional);
    }
}