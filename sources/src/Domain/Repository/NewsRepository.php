<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepository
{
    public function save(News $news): void;

    public function getNewsByIds(iterable $ids): array;

    public function findAll(): array;
}