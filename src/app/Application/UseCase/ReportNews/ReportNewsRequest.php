<?php

namespace App\Application\UseCase\ReportNews;

class ReportNewsRequest
{
    /**
     * @param int[] $ids
     */
    public function __construct(
        public readonly array $ids,
    )
    {
    }
}
