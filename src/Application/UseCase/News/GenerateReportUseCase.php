<?php

declare(strict_types=1);

namespace App\Application\UseCase\News;

use App\Application\UseCase\News\Converter\ReportConverterInterface;
use App\Application\Gateway\ReportExporterInterface;
use App\Application\Settings\SettingsInterface;
use App\Domain\DataProvider\ReportDataProvider;

class GenerateReportUseCase
{
    public function __construct(
        private ReportDataProvider $reportDataProvider,
        private ReportConverterInterface $reportConverter,
        private ReportExporterInterface $reportExporter,
    ) {
    }

    public function __invoke(SettingsInterface $settings, int ...$ids): mixed
    {
        $reportLines = ($this->reportDataProvider)(...$ids);

        $reportView = $this->reportConverter->convert(...$reportLines);

        return $this->reportExporter->export($reportView, $this->reportConverter, $settings);
    }
}
