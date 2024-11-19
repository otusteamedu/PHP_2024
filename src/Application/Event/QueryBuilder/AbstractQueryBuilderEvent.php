<?php

namespace App\Application\Event\QueryBuilder;

class AbstractQueryBuilderEvent
{
    public function __construct(
        public readonly string $databaseQueryResultClassName,
        public readonly string $eventClassName,
        public readonly ?string $query,
        public readonly ?array $result,
    ) {
    }
}
