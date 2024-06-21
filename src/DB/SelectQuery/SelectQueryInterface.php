<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\SelectQuery;

use AlexanderGladkov\DB\QueryResult\QueryResultInterface;

interface SelectQueryInterface
{
    public function from(string $table): static;
    public function where(string $field, string|int $value): static;
    public function orderBy(string $field, string $direction): static;
    public function execute(): QueryResultInterface;
}
