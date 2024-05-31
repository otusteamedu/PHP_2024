<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Service\DTO\ReportGeneratorInputDto;
use App\Application\Service\DTO\ReportGeneratorOutputDto;
use App\Application\Service\ReportGeneratorInterface;
use App\Application\Service\UuidGeneratorInterface;
use App\Domain\Entity\News;
use App\Domain\ValueObject\Url;

class NewsHtmlReportGenerator implements ReportGeneratorInterface
{
    public function __construct(
        private readonly string $reportFilePath,
        private readonly string $reportUrl,
        private readonly string $newsReportFilePrefix,
        private readonly UuidGeneratorInterface $uuidGenerator,
    ) {
    }

    public function generateReport(ReportGeneratorInputDto $inputDto): ReportGeneratorOutputDto
    {
        $reportContent = $this->createContent($inputDto->newsList);
        $reportDate = date('Ymd_His');

        $filename = $this->newsReportFilePrefix . $this->uuidGenerator->generateUuid() . $reportDate . '.html';
        $filePath = $this->reportFilePath . DIRECTORY_SEPARATOR . $filename;

        file_put_contents($filePath, $reportContent);
        $reportUrl = $this->reportUrl . DIRECTORY_SEPARATOR . $filename;

        return new ReportGeneratorOutputDto(new Url($reportUrl));
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
