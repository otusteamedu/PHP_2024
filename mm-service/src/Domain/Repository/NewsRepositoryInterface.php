<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;
use App\Domain\Exception\NewsNotFoundException;

interface NewsRepositoryInterface
{
    public function save(News $news): void;

    /**
     * @return News[]
     */
    public function findAll(): array;

    /**
     * @param int[] $ids
     *
     * @return News[]
     *
     * @throws NewsNotFoundException
     */
    public function findByIds(array $ids): array;
}
