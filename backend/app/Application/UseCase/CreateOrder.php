<?php

namespace App\Application\UseCase;

use App\Application\Interface\Repository;
use App\Domain\Entity\OrderEntity;

readonly class CreateOrder
{
    public function __construct(
        private OrderEntity $order,
        private Repository  $repository,
    ){}

    public function __invoke()
    {
        return $this->repository->save($this->order);
    }

}
