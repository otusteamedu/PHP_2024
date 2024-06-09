<?php

namespace App\Domain\Contract;

interface RepositoryInterface
{
    public function getAll(): array;
    public function getByIds(array $ids): array;
    public function save(EntityInterface $entity): int;
}
