<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\GenerateReport;

final readonly class GenerateReportRequest
{
    public function __construct(
        public array $postIds = [],
    ) {}
}
