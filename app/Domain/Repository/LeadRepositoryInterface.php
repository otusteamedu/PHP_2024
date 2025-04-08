<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Lead;

interface LeadRepositoryInterface
{
    public function findById(int $id): ?Lead;

    public function save(Lead $lead): void;

    public function update(Lead $lead): void;
}
