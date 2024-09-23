<?php

namespace App\Application\Enums\Recipes;

use App\Application\Decorators\Recipes\Burgers\ClassicBurgerDecorator;
use App\Application\Decorators\Recipes\Burgers\VeggieBurgerDecorator;
use App\Domain\Decorators\Recipes\RecipeDecoratorInterface;

enum BurgerType: string
{
    case CLASSIC = 'classic';
    case VEGGIE = 'veggie';

    /**
     * @return class-string<RecipeDecoratorInterface>
     */
    public function getRecipe(): string
    {
        return match ($this) {
            self::CLASSIC => ClassicBurgerDecorator::class,
            self::VEGGIE => VeggieBurgerDecorator::class,
        };
    }
}