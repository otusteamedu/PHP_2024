<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCace\CookingOrderInterface;
use App\Application\Observer\PublisherInterface;
use App\Domain\Entity\Order;
use App\Application\Observer\ProductStatus;
use App\Application\EventManager;

class CookingOrderUseCaseProxy extends CookingOrderUseCase
{
    protected $class;
    private $methodServing;

    public function __construct(private readonly PublisherInterface $publisher, EventManager $eventManager)
    {
        $this->class = new CookingOrderUseCase($publisher, $eventManager);
    }

    public function processCooking(Order $order): void
    {
        $this->class->processCooking($order);

        $this->methodServing = $order->getMethodServing();

        $this->packagingOrder();

        $this->class->sendNotifyOrderReady();
    }

    private function packagingOrder()
    {
        $messagePackaging = "";

        switch (strtolower($this->methodServing->getName())) {
            case 'tray':
                $messagePackaging = "Подача заказа на подносе";
                break;
            case 'package':
                $messagePackaging = "Упаковка заказа в пакет";
                break;
        }

        echo $messagePackaging . PHP_EOL;
    }
}
