<?php

namespace Domain\Repositories;

use Domain\Entities\Movie;

interface MovieRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?Movie;

    public function save(Movie $movie): string|false;

    public function delete(int $id): void;
}
