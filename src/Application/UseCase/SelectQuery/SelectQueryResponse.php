<?php

namespace App\Application\UseCase\SelectQuery;

use App\Domain\SelectQuery\DatabaseQueryResult;

class SelectQueryResponse
{
    public function __construct(
        public readonly DatabaseQueryResult $queryResult
    ) {
    }
}
