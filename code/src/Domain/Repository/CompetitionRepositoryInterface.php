<?php

declare(strict_types=1);

namespace Irayu\Hw13\Domain\Repository;

interface CompetitionRepositoryInterface
{
    public function findByFilter(?array $filter, ?array $sort, ?int $offset, ?int $limit): array;
}
