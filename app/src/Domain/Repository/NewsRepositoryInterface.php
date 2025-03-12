<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Domain\Repository;

use PavelMiasnov\MediaMonitoring\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;
    public function findAll(): array;
    public function findByIds(array $ids): array;
}
