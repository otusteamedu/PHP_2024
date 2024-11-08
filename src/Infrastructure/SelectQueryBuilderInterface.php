<?php

namespace App\Application\QueryBuilder;

interface SelectQueryBuilderInterface
{
    public function from(string $table): self;
    public function where(string $field, string|int $value, string $operator = '='): self;
    public function orderBy(string $field, string $direction = 'DESC'): self;
    public function limit(int $limit, int $offset = 0): self;
    public function execute(bool $lazy = true): DatabaseQueryResult;
}
