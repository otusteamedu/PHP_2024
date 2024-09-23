<?php

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