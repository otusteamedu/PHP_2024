<?php

declare(strict_types=1);

namespace App\Infrastructure\Helper;

use App\Application\Helper\DTO\NewsReportDTO;
use App\Application\Helper\DTO\ReportDTO;
use App\Application\Helper\ReportGeneratorInterface;

readonly class ReportGenerator implements ReportGeneratorInterface
{
    public function __construct(private string $baseUrl)
    {
    }

    /**
     * @param list<NewsReportDTO> $newsReportDTOList
     * @return ReportDTO
     */
    public function generate(array $newsReportDTOList): ReportDTO
    {
        $html = $this->generateHtml($newsReportDTOList);

        $reportPath = $this->saveReport($html);

        $reportUrl = $this->generateReportUrl($reportPath);
        return new ReportDTO($reportUrl);
    }

    /**
     * @param list<NewsReportDTO> $newsReportDTOList
     * @return string
     */
    private function generateHtml(array $newsReportDTOList): string
    {
        $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
</head>
<body>
    <h1>News Report</h1>
    <ul>
HTML;

        foreach ($newsReportDTOList as $news) {
            $html .= sprintf('<li><a href="%s">%s</a></li>', $news->url, $news->title);
        }

        $html .= '</ul>
</body>
</html>';

        return $html;
    }

    private function saveReport(string $html): string
    {
        $report = 'report_' . uniqid() . '.html';
        $reportPath = __DIR__ . '/../../../public/reports/' . $report;
        file_put_contents($reportPath, $html);

        return $reportPath;
    }

    private function generateReportUrl(string $reportPath): string
    {
        return $this->baseUrl . '/reports/' . basename($reportPath);
    }
}
