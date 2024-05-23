<?php

declare(strict_types=1);

namespace App\Infrastructure\Helper;

use App\Application\Helper\ReportGeneratorInterface;
use App\Domain\Entity\News;

readonly class ReportGenerator implements ReportGeneratorInterface
{
    public function __construct(private string $baseUrl)
    {
    }

    /**
     * @param list<News> $newsList
     * @return string
     */
    public function generate(array $newsList): string
    {
        $html = $this->generateHtml($newsList);

        $reportPath = $this->saveReport($html);

        return $this->generateReportUrl($reportPath);
    }

    /**
     * @param list<News> $newsList
     * @return string
     */
    private function generateHtml(array $newsList): string
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

        foreach ($newsList as $news) {
            $html .= sprintf('<li><a href="%s">%s</a></li>', $news->getUrl()->getValue(), $news->getTitle()->getValue());
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
