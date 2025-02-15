<?php

namespace App\Domain\Repository;

readonly class FeedAllParameters
{
    public function __construct(
        public int $limit,
        public int $page,
    ) {
    }
}
