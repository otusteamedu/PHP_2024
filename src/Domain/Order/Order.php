<?php

declare(strict_types=1);

namespace App\Domain\Order;

use App\Domain\Enum\OrderStatuses;
use App\Domain\Event\OrderStatusChanged;
use App\Domain\Interface\PublisherInterface;

class Order
{
    private int $id;
    private OrderStatuses $status;

    public function __construct(private readonly PublisherInterface $publisher) {}

    public function getStatus(): OrderStatuses
    {
        return $this->status;
    }

    public function setStatus(OrderStatuses $status): self
    {
        $this->status = $status;

        $this->publisher->notify(new OrderStatusChanged($this, $status));

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
