<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\ChainOfResponsibility\SandwichHandler;
use App\Application\ChainOfResponsibility\BurgerHandler;
use App\Application\ChainOfResponsibility\HotdogHandler;
use App\Application\Observer\PublisherInterface;
use App\Application\Observer\ProductStatus;
use App\Application\UseCase\CookingOrderInterface;
use App\Domain\Entity\Order;
use App\Application\EventManager;

class CookingOrderUseCase implements CookingOrderInterface
{
    private $order;
    private $eventManager;
    private $cookedProduct;

    public function __construct(private readonly PublisherInterface $publisher, EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function processCooking(Order $order): void
    {
        $this->order = $order;
        $this->sendNotifyNewOrder();
        $this->SendingToKitchen();

        $this->prepare();

        $this->returnFromKitchen();
    }

    private function prepare()
    {
        $this->cookOrder();
        $this->checkStandart();
    }

    public function sendNotifyOrderReady()
    {
        $this->publisher->notify(new ProductStatus("[-- Заказ готов --]"));
    }

    public function sendNotifyNewOrder()
    {
        $this->publisher->notify(new ProductStatus("[-- Заказ принят --]"));
    }

    private function sendingToKitchen()
    {
        echo "Заказ поступил на кухню" . PHP_EOL;
    }

    private function cookOrder()
    {
        $productHandler = new BurgerHandler();
        $productHandler
            ->setNext(new SandwichHandler())
            ->setNext(new HotdogHandler());

        $this->cookedProduct = $productHandler->handleOrder($this->order->getProduct(), $this->order->getIngredients());
    }

    private function checkStandart(): bool
    {
        echo "Проверка заказа на соотвествие стандарту ";

        //имимтация на проверку стандарту
        if (rand(0, 1) === 1) {
            echo " [успех!] " . PHP_EOL;
            return true;
        } else {
            echo " [неудача!] " . PHP_EOL;
            $this->eventManager->trigger('dispose_product');
            unset($this->cookedProduct);
            $this->prepare();
        }
        return false;
    }

    private function packagingOrder()
    {
    }

    private function returnFromKitchen()
    {
        echo "Возврат заказа кассиру " . PHP_EOL;
    }
}
