<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\NewsEntity;

interface NewsRepositoryInterface
{
    /**
     * @return NewsEntity[]
     */
    public function all(): iterable;

    public function findById(int $id): ?NewsEntity;

    /**
     * @return NewsEntity[]
     */
    public function findMultipleById(int ...$ids): iterable;

    public function save(NewsEntity $newsEntity): void;

    public function delete(NewsEntity $newsEntity): void;
}
