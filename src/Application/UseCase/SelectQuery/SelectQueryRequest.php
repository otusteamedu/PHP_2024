<?php

namespace App\Application\UseCase\SelectQueryBuilder;

use App\Domain\DTO\SelectQueryBuilder\WhereDTO;

class SelectQueryBuilderRequest
{
    /**
     * @param string $from
     * @param WhereDTO[]|null $where
     * @param string|null $orderBy
     * @param string|null $direction
     * @param int|null $limit
     * @param int|null $offset
     * @param bool|null $lazy
     */
    public function __construct(
        public readonly string $from,
        public readonly ?array $where,
        public readonly ?string $orderBy,
        public readonly ?string $direction,
        public readonly ?int $limit,
        public readonly ?int $offset,
        public readonly ?bool $lazy
    ) {
    }
}
