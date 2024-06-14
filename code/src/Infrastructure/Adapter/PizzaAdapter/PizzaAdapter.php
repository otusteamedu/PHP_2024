<?php
declare(strict_types=1);

namespace App\Infrastructure\Adapter\PizzaAdapter;

use App\Application\Interface\RecipeInterface;
use App\Application\Interface\StrategyInterface;

class PizzaAdapter implements StrategyInterface
{
    private string $type;


    public function __construct(
        private readonly RecipeInterface $pizza
    )
    {
        $this->type = 'pizza';
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRecipe(): string
    {
        return $this->pizza->getRecipe();
    }
}