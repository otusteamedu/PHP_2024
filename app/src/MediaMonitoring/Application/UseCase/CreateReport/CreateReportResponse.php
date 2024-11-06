<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreateReport;

final readonly class CreateReportResponse
{
    public function __construct(
        public int $reportId
    ) {}
}
