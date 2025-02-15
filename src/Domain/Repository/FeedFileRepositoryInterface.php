<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Feed;

interface FeedFileRepositoryInterface
{
    /**
     * @param Feed[] $feeds
     */
    public function saveReport(array $feeds): string;
}
