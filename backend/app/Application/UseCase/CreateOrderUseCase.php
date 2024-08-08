<?php

namespace App\Application\UseCase;

use App\Application\Interface\Repository;
use App\Domain\Entity\OrderEntity;

class CreateOrderUseCase
{
    public function __construct(
        public OrderEntity $order,
        public Repository  $repository,
    ){}

    public function __invoke(): int
    {
        return $this->repository->save($this->order);
    }

}
