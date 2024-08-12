<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RequestProcessEntity;

interface RequestProcessRepositoryInterface
{
    public function findById(int $id): ?RequestProcessEntity;
    public function add(): RequestProcessEntity;

    public function update(int $id, string $uuid): void;
}
