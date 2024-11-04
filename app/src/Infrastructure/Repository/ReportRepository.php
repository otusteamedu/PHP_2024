<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Report;
use App\Domain\Entity\ReportFile;
use App\Domain\Repository\ReportRepositoryInterface;
use App\Infrastructure\Helpers\LoadConfig;

class ReportRepository implements ReportRepositoryInterface
{
    private string $reportPath;

    public function __construct()
    {
        $config = LoadConfig::load();
        $this->reportPath = $config['reportsPath'];
        if (!file_exists($this->reportPath)) {
            throw new \DomainException('No isset file path for reports: ' . $this->reportPath);
        }
    }

    public function save(Report $report): ReportFile
    {
        $fileName = date("Ymd_His") . ".html";
        $this->saveInFile($report->getHtml(), $fileName);

        return new ReportFile($this->reportPath . $fileName);
    }

    private function saveInFile(string $data, string $fileName): void
    {
        if (!file_put_contents($this->reportPath . $fileName, $data)) {
            throw new \DomainException('Error save file report');
        }
    }
}
