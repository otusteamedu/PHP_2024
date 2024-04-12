<?php

declare(strict_types=1);

namespace App\News\Domain\Repository;

use App\News\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function create(News $news): void;

    public function findById(int $id): ?News;

    public function findAll(): array;
}