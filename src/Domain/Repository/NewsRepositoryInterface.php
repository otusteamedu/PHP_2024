<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function add(News $news): void;

    /**
     * @return list<News>
     */
    public function findAll(): array;

    /**
     * @param array $ids
     * @return list<News>
     */
    public function findByIds(array $ids): array;
}
