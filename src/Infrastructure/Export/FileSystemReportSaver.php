<?php

declare(strict_types=1);

namespace App\Infrastructure\Export;

use App\Application\UseCase\News\Converter\ReportConverterInterface;
use App\Application\Gateway\ReportExporterInterface;
use App\Application\Settings\SettingsInterface;

class FileSystemReportSaver implements ReportExporterInterface
{
    public function export(
        string $report,
        ReportConverterInterface $converter,
        ?SettingsInterface $settings = null
    ): mixed {
        if ($settings === null || $settings->get('path_to_reports_dir') === null) {
            throw new \InvalidArgumentException('Option "path_to_reports_dir" is required');
        }

        $filename = $this->generateReportFileName(
            $settings->get('path_to_reports_dir'),
            $converter->fileExtension()
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
}
