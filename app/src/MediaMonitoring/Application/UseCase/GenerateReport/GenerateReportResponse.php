<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\GenerateReport;

final readonly class GenerateReportResponse
{
    public function __construct(
        public string $path,
    ) {}
}
