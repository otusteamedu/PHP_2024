<?php

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    /**
     * @return News[]
     */
    public function findAll(): iterable;

    public function findById(int $id): ?News;

    /**
     * @param int[] $ids
     * @return News[]
     */
    public function findByIds(array $ids): iterable;

    public function save(News $news): void;
}
