<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\UseCase\GenerateReport;

class GenerateReportRequest
{
    private array $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function getIds(): array
    {
        return $this->ids;
    }
}
