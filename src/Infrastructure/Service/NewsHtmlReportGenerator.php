<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\News;
use App\Domain\Service\ReportGeneratorInterface;

class NewsHtmlReportGenerator implements ReportGeneratorInterface
{
    public function __construct(
        private readonly string $reportFilePath,
        private readonly string $reportUrl,
    ) {
    }

    /**
     * @param News[] $data
     */
    public function generateReport(array $data): string
    {
        $reportContent = $this->createContent($data);

        $filename = 'news_report_' . date('Ymd_His') . '.html';
        $filePath = $this->reportFilePath . DIRECTORY_SEPARATOR . $filename;

        file_put_contents($filePath, $reportContent);

        return $this->reportUrl . $filePath;
    }

    /**
     * @param News[] $newsList
     */
    private function createContent(array $newsList): string
    {
        $reportContent = "<ul>" . PHP_EOL;

        foreach ($newsList as $news) {
            $url = $news->getUrl()->getValue();
            $title = $news->getTitle()->getValue();
            $reportContent .= "<li><a href=\"{$url}\">{$title}</a></li>" . PHP_EOL;
        }

        $reportContent .= "</ul>" . PHP_EOL;

        return $reportContent;
    }
}
