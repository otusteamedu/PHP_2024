<?php

namespace App\Domain\Repository;

readonly class FeedAllParameters
{
    function __construct(
        public int $limit,
        public int $page,
    )
    {
    }
}