<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\DTO\SelectQueryBuilder\WhereDTO;
use App\Domain\SelectQueryBuilder\DatabaseQueryResult;

interface SelectQueryBuilderInterface
{
    public function from(string $table): self;
    public function where(string $field, string|int $value, string $operator = '='): self;
    /** @var WhereDTO[] $whereDTO */
    public function whereDTO(array $whereDTOArray): self;
    public function orderBy(string $field, string $direction = 'DESC'): self;
    public function limit(int $limit, int $offset = 0): self;
    public function execute(bool $lazy = true): DatabaseQueryResult;
}
