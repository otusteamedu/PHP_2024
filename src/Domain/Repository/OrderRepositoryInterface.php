<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Domain\Repository;

use RailMukhametshin\Hw\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
    public function findById(int $id):?Order;
}