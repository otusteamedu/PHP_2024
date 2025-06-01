<?php

namespace App\Observer;

use App\FoodItem\FoodItemInterface;

class Order implements OrderSubjectInterface
{
    private array $observers = [];
    private int $orderId;
    private FoodItemInterface $foodItem;

    public function __construct(int $orderId, FoodItemInterface $foodItem)
    {
        $this->orderId = $orderId;
        $this->foodItem = $foodItem;
    }

    public function attach(OrderObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(OrderObserverInterface $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function notify(string $status, int $orderId): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($status, $orderId);
        }
    }

    public function processOrder(): void
    {
        $this->notify("Order received", $this->orderId);
        $this->foodItem->prepare();
        $this->notify("Preparation complete", $this->orderId);
        $this->notify("Ready for pickup", $this->orderId);
    }
}
