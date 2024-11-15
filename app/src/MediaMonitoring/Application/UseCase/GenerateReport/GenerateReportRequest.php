<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\GenerateReport;

final readonly class GenerateReportRequest
{
    public array $postIds;

    public function __construct(
        int ...$postIds,
    ) {
        $this->postIds = $postIds;
    }
}
