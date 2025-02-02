<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Domain\Repository;

use Asyrovatkin\Hw14\Domain\Entity\News;

interface NewsRepositoryInterface
{
    /**
     * @return News[]
     */
    public function findAll(): array;

    /**
     * @param int[] $ids
     * @return News[]
     */
    public function findByIds(array $ids): array;

    public function save(News $news): News;
}