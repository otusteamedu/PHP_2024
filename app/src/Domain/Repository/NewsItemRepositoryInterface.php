<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\NewsItem;

interface NewsItemRepositoryInterface
{
    public function findAll(): iterable;

    public function findBy(array $params): iterable;

    public function findById(int $id): ?NewsItem;

    public function save(NewsItem $news): void;

    public function delete(NewsItem $news): void;
}
