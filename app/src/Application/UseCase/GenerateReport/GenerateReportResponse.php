<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\UseCase\GenerateReport;

class GenerateReportResponse
{
    private string $reportUrl;

    public function __construct(string $reportUrl)
    {
        $this->reportUrl = $reportUrl;
    }

    public function getReportUrl(): string
    {
        return $this->reportUrl;
    }
}
