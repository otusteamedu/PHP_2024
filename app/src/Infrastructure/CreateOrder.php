<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Entity\Food\Sandwich;
use App\Domain\Entity\Food\Burger;
use App\Domain\Entity\Food\Hotdog;
use App\Domain\Entity\Ingredients\Cheese;
use App\Domain\Entity\Ingredients\Cucumber;
use App\Domain\Entity\Ingredients\Ham;
use App\Domain\Entity\Ingredients\Meat;
use App\Domain\Entity\Ingredients\Onion;
use App\Domain\Entity\Ingredients\Pepper;
use App\Domain\Entity\Ingredients\Salad;
use App\Domain\Entity\Ingredients\Sauce;
use App\Domain\Entity\Ingredients\Sausage;
use App\Application\UseCase\CookingOrderUseCase;
use App\Application\Observer\Publisher;
use App\Application\Observer\PrintNewStatus;
use App\Domain\Entity\Order;
use App\Domain\Entity\MethodServing\Tray;
use App\Domain\Entity\MethodServing\Package;
use App\Application\UseCase\CookingOrderUseCaseProxy;
use App\Application\EventManager;

class CreateOrder
{
    public function __construct(private readonly CookingOrderUseCase $createOrderService)
    {
    }
    public static function create(string $product, array $ingredients, string $methodServing)
    {

        $arIngredientsObject = [];

        switch ($product) {
            case 'burger':
                $productObject = new Burger();
                break;
            case 'sandwich':
                $productObject = new Sandwich();
                break;
            case 'hotdog':
                $productObject = new Hotdog();
                break;
        }

        switch ($methodServing) {
            case 'tray':
                $servingObject = new Tray();
                break;
            case 'package':
                $servingObject = new Package();
                break;
        }

        foreach ($ingredients as $ingredient) {
            $arIngredientsObject[] = match ($ingredient) {
                'cheese' => new Cheese(),
                'cucumber' => new Cucumber(),
                'ham' => new Ham(),
                'meat' => new Meat(),
                'onion' => new Onion(),
                'pepper' => new Pepper(),
                'salad' => new Salad(),
                'sauce' => new Sauce(),
                'sausage' => new Sausage()
            };
        }

        $publisher = new Publisher();
        $publisher->subscribe(new PrintNewStatus());

        $order = new Order($productObject, $arIngredientsObject, $servingObject);

        $eventManager = new EventManager();

        $eventManager->addEvent('dispose_product', function () {
            echo "-->>>Утилизируем продукт<<<--" . PHP_EOL;
        });

        $cookNewOrder = new CookingOrderUseCaseProxy($publisher, $eventManager);
        $cookNewOrder->ProcessCooking($order);
    }
}
