<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\Repository;

use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;
    public function findByUrl(string $url): ?News;
    public function findByIds(array $ids): array;
    public function findAll(): array;
}