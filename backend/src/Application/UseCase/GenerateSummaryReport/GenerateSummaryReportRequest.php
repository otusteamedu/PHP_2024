<?php

namespace App\Application\UseCase\GenerateSummaryReport;

readonly class GenerateSummaryReportRequest
{
    /**
     * @param int[] $ids
     */
    public function __construct(
        public array $ids,
    ) {
    }
}
