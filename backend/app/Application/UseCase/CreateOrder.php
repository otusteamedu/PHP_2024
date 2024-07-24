<?php

namespace App\Application\UseCase;

use App\Application\DTO\DTO;
use App\Domain\Entity\Order;

class CreateOrder
{

    private int $status = 1;
    public function __construct(
        private readonly Order $order
    ){}

    public function __invoke(): DTO
    {
        return new DTO(
            $this->status,
            $this->order->getCurFrom(),
            $this->order->getCurTo(),
            $this->order->getAmountFrom(),
            $this->order->getAmountTo(),
            $this->order->getRate()
        );

    }

}
