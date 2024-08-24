<?php

declare(strict_types=1);

namespace App\Application\UseCase\Report;

class ReportRequest
{
    /**
     *
     * @param integer[] $ids
     */
    public function __construct(
        public array $ids
    ) {
    }
}
