<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\CustomStrategy;

use App\Application\Interface\RecipeInterface;
use App\Application\Interface\StrategyInterface;

class CustomStrategy implements StrategyInterface
{

    # прописать возможность загружать тут адаптеры

    private string $type;
    public function __construct(
        private readonly RecipeInterface $recipeBurger
    ){
        $this->type = 'burger';
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRecipe(): string
    {
        return $this->recipeBurger->getRecipe();
    }
}