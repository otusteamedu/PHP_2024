<?php

namespace App\Application\UseCase;

use App\Domain\Decorator\LettuceDecorator;
use App\Domain\Decorator\MealDecorator;
use App\Domain\Decorator\OnionDecorator;
use App\Domain\Decorator\PepperDecorator;
use App\Domain\Entity\Meal;
use App\Domain\Factory\MealFactoryInterface;
use App\Domain\Strategy\CookingStrategyInterface;

class CreateMealUseCase
{
    public function __construct(
        private readonly MealFactoryInterface $mealFactory,
        private readonly CookingStrategyInterface $cookingStrategy,
    ) {
    }

    public function __invoke(string $mealType, array $ingredients): void
    {
        $meal = $this->mealFactory->createMeal($mealType);

        foreach ($ingredients as $ingredient) {
            $meal = $this->decorateMeal($meal, $ingredient);
        }

        $this->takeOrder($meal);
        $this->sendToKitchen($meal);
        $this->cookingStrategy->cook($meal);
        $this->returnToCounter($meal);
    }

    private function takeOrder(Meal $meal): void
    {
        echo "Order " . $meal->getName() . " submitted.\n";
    }

    private function sendToKitchen(Meal $meal): void
    {
        echo "Order " . $meal->getName() . " goes to kitchen.\n";
    }

    private function returnToCounter(Meal $meal): void
    {
        echo $meal->getName() . " completed.\n";
    }

    private function decorateMeal($meal, string $ingredient): MealDecorator
    {
        return match ($ingredient) {
            'lettuce' => new LettuceDecorator($meal),
            'onion' => new OnionDecorator($meal),
            'pepper' => new PepperDecorator($meal),
            default => $meal,
        };
    }
}
