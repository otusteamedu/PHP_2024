<?php

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    /**
     * @return News[]
     */
    public function all(): array;
    /**
     * @return News[]
     */
    public function findByIds(array $ids): array;

    public function save(News $news): void;
}
