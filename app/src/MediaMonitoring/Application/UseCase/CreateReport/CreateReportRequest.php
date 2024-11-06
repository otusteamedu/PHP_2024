<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreateReport;

use App\MediaMonitoring\Domain\Enum\ReportType;

final readonly class CreateReportRequest
{
    public function __construct(
        public ReportType $type,
        public string $content,
    ) {}
}
