<?php

namespace App\Infrastructure;

use App\Application\UseCase\CookFood\CookFoodRequest;
use App\Application\UseCase\CookFood\CookFoodUseCase;
use App\Application\UseCase\CreateFood\CreateFoodRequest;
use App\Application\UseCase\CreateFood\CreateFoodUseCase;
use App\Domain\Entity\FoodComposite;
use App\Domain\Entity\Garlic;
use App\Domain\Entity\Salad;
use App\Infrastructure\Composite\GenerateBurgerGateway;
use App\Infrastructure\Observer\StatusPublisher;
use App\Infrastructure\Strategy\BurgerStrategy;
use App\Infrastructure\Strategy\SandwichStrategy;

class App
{
    public function run()
    {
        $food = $this->generateSandwich();
        $this->cook($food);
    }

    private function generateBurger()
    {
        $name = 'Бургер N1';

        $request = new CreateFoodRequest($name);
        $response = (new CreateFoodUseCase(new BurgerStrategy()))($request);

        return $response->food;
    }

    private function generateSandwich()
    {
        $name = 'Сэндвич #1';

        $request = new CreateFoodRequest($name);
        $response = (new CreateFoodUseCase(new SandwichStrategy()))($request);

        return $response->food;
    }

    private function cook(FoodComposite $foodComposite)
    {
        $userFoodAdditives = [
            new Garlic('Чеснок'),
            new Salad('Салат'),
        ];

        $request = new CookFoodRequest($foodComposite, $userFoodAdditives);
        $response = (new CookFoodUseCase(new GenerateBurgerGateway(), new StatusPublisher()))($request);
    }
}