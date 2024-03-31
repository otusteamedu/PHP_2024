<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Infrastructure\Repository;

use RailMukhametshin\Hw\Domain\Entity\Order;
use RailMukhametshin\Hw\Domain\Repository\OrderRepositoryInterface;

class MemoryOrderRepository implements OrderRepositoryInterface
{
    private array $orders = [];
    public function save(Order $order): void
    {
        $this->orders[$order->getId()] = $order;
    }

    public function findById(int $id): ?Order
    {
        return $this->orders[$id];
    }
}