<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\Repository;

use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;
    public function findByUrl(string $url): ?News;

    /**
     * @param array $ids
     * @return News[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return News[]
     */
    public function findAll(): array;
}
