<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsInterface
{
    /**
     * @param News $news
     * @return void
     */
    public function save(News $news): void;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param $limit
     * @param $offset
     * @return News[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;
}
