<?php

namespace Ahar\hw15\src\Domain\Contract;

interface NewsRepositoryInterface
{
    public function findOne(int $id): ?object;

    public function save(object $entity): void;

    public function findAll(): array;

}
