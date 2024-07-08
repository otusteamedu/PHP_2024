<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Application\UseCase\News\DTO\ExportedReport;
use App\Domain\Enum\ReportFormat;

interface ReportExporterInterface
{
    public function export(string $report, ReportFormat $reportFormat): ExportedReport;
}
