<?php

namespace App\Infrastructure\Composite;

use App\Application\Composite\FoodCompositeInterface;
use App\Application\Composite\FoodCompositeRequest;
use App\Application\Composite\FoodCompositeResponse;
use App\Domain\Entity\Bread;
use App\Domain\Entity\Cheese;
use App\Domain\Entity\Mayonnaise;
use App\Domain\Entity\Salad;
use App\Domain\Entity\Sauce;

class GenerateSandwichGateway implements FoodCompositeInterface
{
    public function composite(FoodCompositeRequest $request): FoodCompositeResponse
    {
        $food = $request->foodComposite;

        $food->add(new Bread('Круглая булочка'));
        $food->add(new Cheese('Твердый сыр'));
        $food->add(new Salad('Салат'));

        $sauce = new Sauce('Сырный соус');
        $sauce->add(new Cheese('Натерный сыр'));
        $sauce->add(new Mayonnaise('Майонез'));

        $food->add($sauce);

        foreach ($request->foodAdditives as $foodAdditive) {
            $food->add($foodAdditive);
        }

        return new FoodCompositeResponse($food);
    }
}