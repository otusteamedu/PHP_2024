<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Purchase;
use App\Domain\RepositoryInterface\PurchaseRepositoryInterface;

class PurchaseRepository extends AbstractRepository implements PurchaseRepositoryInterface
{
    public function create(Purchase $purchase): int
    {
        return $this->store($purchase);
    }

    public function update(Purchase $purchase): void
    {
        $this->store($purchase);
    }

    public function getPurchaseById(int $id): Purchase
    {
        return  $this->entityManager->getRepository(Purchase::class)->findOneBy(['id' => $id]);
    }

    public function remove(Purchase $purchase): void
    {
        $this->entityManager->remove($purchase);
        $this->flush();
    }
}
