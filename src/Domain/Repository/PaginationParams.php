<?php

namespace App\Domain\Repository;

readonly class PaginationParams
{
    public function __construct(
        public int $limit,
        public int $page,
    ) {
    }
}
