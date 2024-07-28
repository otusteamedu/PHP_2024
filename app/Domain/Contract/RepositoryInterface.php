<?php

namespace App\Domain\Contract;

interface RepositoryInterface
{
    public function getAll(): array;
    public function getByIds(array $ids): array;
    public function save($entity): int;
    public function findBy(string $column, mixed $value): array;
}
