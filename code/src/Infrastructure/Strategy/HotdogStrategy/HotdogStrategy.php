<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\HotdogStrategy;

use App\Application\Interface\RecipeInterface;
use App\Application\Interface\StrategyInterface;

class HotdogStrategy implements StrategyInterface
{
    private string $type;
    public function __construct(
        private readonly RecipeInterface $recipeHotdog
    ){
        $this->type = 'hotdog';
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRecipe(): string
    {
        return $this->recipeHotdog->getRecipe();
    }
}