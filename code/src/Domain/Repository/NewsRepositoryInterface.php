<?php

declare(strict_types=1);

namespace Irayu\Hw15\Domain\Repository;

use Irayu\Hw15\Domain\Entity\NewsItem;

interface NewsRepositoryInterface
{
    public function save(NewsItem $newsItem): void;

    public function findById(int $id): ?NewsItem;

    /**
     * @return NewsItem[]
     */
    public function getAll(): array;

    /**
     * @return NewsItem[]
     */
    public function getByPage(int $pageNumber, int $pageSize): array;
}
