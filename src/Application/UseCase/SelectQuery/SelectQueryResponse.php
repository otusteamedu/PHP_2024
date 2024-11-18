<?php

namespace App\Application\UseCase\SelectQueryBuilder;

use App\Domain\SelectQueryBuilder\DatabaseQueryResult;

class SelectQueryBuilderResponse
{
    public function __construct(
        public readonly DatabaseQueryResult $queryResult
    ) {
    }
}
