<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Lead;

interface LeadRepositoryInterface
{
    /**
     * @return Lead[]
     */
    public function findAll(): iterable;

    public function findById(int $id): ?Lead;

    /**
     * @param int[] $ids
     * @return Lead[]
     */
    public function findByIds(array $ids): iterable;

    public function save(Lead $lead): void;

}
