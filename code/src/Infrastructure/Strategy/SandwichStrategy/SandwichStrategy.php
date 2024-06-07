<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\SandwichStrategy;

use App\Application\Interface\RecipeInterface;
use App\Application\Interface\StrategyInterface;

class SandwichStrategy implements StrategyInterface
{
    private string $type;
    public function __construct(
        private readonly RecipeInterface $recipeSandwich
    ){
        $this->type = 'sandwich';
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRecipe(): string
    {
        return $this->recipeSandwich->getRecipe();
    }
}