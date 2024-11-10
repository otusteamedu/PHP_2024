<?php

declare(strict_types=1);

namespace Irayu\Hw16;

use Irayu\Hw16\Domain\Dish\MainDish\BurgerFactory;

class App
{
    public function __construct()
    {
    }

    public function run(): void
    {
        $preparationStatus = new Application\PreparationStatus();

        $qualityControlProcess = new Infrastructure\PreparationProcessProxy(
            new Domain\Processes\RecipePreparationStrategy()
        );

        $restaurant = new Presentation\Restaurant(
            $preparationStatus,
            $qualityControlProcess
        );

        $notifier = new Infrastructure\ClientNotifier();
        $preparationStatus->addObserver($notifier);

        $product = $restaurant->serve(new BurgerFactory(), [
            Domain\Dish\Decorator\KetchupDecorator::class,
            Domain\Dish\Decorator\MayonnaiseDecorator::class,
        ]);

        echo $product->getDescription() . PHP_EOL;
    }
}
