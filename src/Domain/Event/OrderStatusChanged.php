<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Enum\OrderStatuses;
use App\Domain\Interface\EventInterface;
use App\Domain\Order\Order;

class OrderStatusChanged implements EventInterface
{
    public function __construct(private readonly Order $order, private readonly OrderStatuses $status) {}

    public function getSource()
    {
        return $this->order;
    }

    public function getPayload()
    {
        return $this->status;
    }
}
