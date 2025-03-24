<?php

namespace App\Application\UseCase\CreateFood;

use App\Application\Strategy\Strategy;

class CreateFoodUseCase
{
    public function __construct(
        private Strategy $stategy
    )
    {
    }

    public function __invoke(CreateFoodRequest $request): CreateFoodResponse
    {
        //Стратегия
        $food = $this->stategy->generateNewFood($request->name);

        return new CreateFoodResponse($food);
    }
}