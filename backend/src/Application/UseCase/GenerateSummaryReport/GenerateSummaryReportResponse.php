<?php

declare(strict_types=1);

namespace App\Application\UseCase\GenerateSummaryReport;

readonly class GenerateSummaryReportResponse
{
    public function __construct(
        public string $reportPath,
    ) {
    }
}
