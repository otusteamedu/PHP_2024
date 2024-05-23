<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\Query\NewsByIdsQuery;

interface NewsRepositoryInterface
{
    public function add(News $news): void;

    /**
     * @return list<News>
     */
    public function findAll(): array;

    /**
     * @param NewsByIdsQuery $query
     * @return list<News>
     */
    public function findByIds(NewsByIdsQuery $query): array;
}
