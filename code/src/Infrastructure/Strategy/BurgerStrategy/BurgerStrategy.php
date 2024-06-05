<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy;

use App\Application\Interface\RecipeInterface;
use App\Application\Interface\StrategyInterface;

class BurgerStrategy implements StrategyInterface
{
    private string $type;
    public function __construct(
        private readonly RecipeInterface $recipe
    ){
        $this->type = 'burger';
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRecipe(): string
    {
        return $this->recipe->getRecipe();
    }
}