<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;

    /**
     * @return News[]
     */
    public function getAll(): array;

    /**
     * @param int[] $ids
     * @return News[]
     */
    public function getByIds(array $ids): array;
}