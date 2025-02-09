<?php

namespace Domain\Repositories;

use Domain\Entities\Theatre;

interface TheatreRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?Theatre;

    public function save(Theatre $entity): void;

    public function delete(int $id): void;
}