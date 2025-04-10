<?php

declare(strict_types=1);

namespace Valen\App\Domain\News\Repository;

use Valen\App\Domain\News\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;
    public function delete(int $newsId): void;
    public function findById(int $newsId): ?News;

    /**
     * @return News[]
     */
    public function findAll(): iterable;
}
