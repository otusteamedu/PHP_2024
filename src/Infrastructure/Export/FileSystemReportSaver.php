<?php

declare(strict_types=1);

namespace App\Infrastructure\Export;

use App\Application\Gateway\ReportExporterInterface;
use App\Domain\Enum\ReportFormat;
use App\Infrastructure\Settings\SettingsInterface;

class FileSystemReportSaver implements ReportExporterInterface
{
    public function __construct(private SettingsInterface $settings)
    {
    }

    public function export(string $report, ReportFormat $reportFormat): mixed
    {
        $reportPath = $this->settings->get('path_to_reports_dir');
        if ($reportPath === null) {
            throw new \InvalidArgumentException('Option "path_to_reports_dir" is required');
        }

        $filename = $this->generateReportFileName(
            $reportPath,
            $this->resolveExtension($reportFormat)
        );

        if (file_put_contents($filename, $report) === false) {
            throw new \RuntimeException('Failed to save report');
        }

        return $filename;
    }

    public function generateReportFileName(string $dirName, string $extension): string
    {
        $dirPath = $this->normalizeDirPath($dirName);
        $reportDate = date('Y-m-d_H-i-s');

        return "$dirPath/report_$reportDate.$extension";
    }

    private function normalizeDirPath(string $dirName): string
    {
        return rtrim($dirName, '/');
    }

    private function resolveExtension(ReportFormat $reportFormat): string
    {
        return match ($reportFormat) {
            ReportFormat::HTML => 'html',
            ReportFormat::PlainText => 'txt',
            ReportFormat::JSON => 'json',
            ReportFormat::CSV => 'csv',
        };
    }
}
