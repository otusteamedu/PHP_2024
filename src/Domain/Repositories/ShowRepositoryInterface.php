<?php

namespace Domain\Repositories;

use Domain\Entities\Show;

interface ShowRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?Show;

    public function save(Show $show): string|false;

    public function delete(int $id): void;
}
