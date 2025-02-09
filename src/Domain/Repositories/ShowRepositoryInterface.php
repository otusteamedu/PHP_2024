<?php

namespace Domain\Repositories;

use Domain\Entities\Show;

interface ShowRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?Show;

    public function save(Show $show): void;

    public function delete(int $id): void;
}
