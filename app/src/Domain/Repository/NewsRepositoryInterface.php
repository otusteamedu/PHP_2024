<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;
use App\Domain\Exception\EntityNotFoundException;

interface NewsRepositoryInterface
{
    public function save(News $news): void;

    /**
     * @return News[]
     */
    public function findAllNews(int $offset, int $limit): array;

    /**
     * @return News[]
     * @throws EntityNotFoundException
     */
    public function findAllByIds(array $ids): array;

    public function getNewsCount(): int;
}
