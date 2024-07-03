<?php

declare(strict_types=1);

namespace App\Application\UseCase\News;

use App\Application\UseCase\News\Converter\ReportConverterInterface;
use App\Application\Gateway\ReportExporterInterface;
use App\Application\UseCase\News\DTO\ExportedReport;
use App\Domain\Entity\News\{News, NewsMapper};
use App\Application\UseCase\News\DTO\ReportResponse;

class GenerateReportUseCase
{
    public function __construct(
        private ReportConverterInterface $reportConverter,
        private ReportExporterInterface $reportExporter,
        private NewsMapper $newsMapper
    ) {
    }

    public function __invoke(int ...$ids): ExportedReport
    {
        $news = $this->newsMapper->findByIds($ids);

        $reportLines = array_map(
            static fn (News $news) => new ReportResponse(
                $news->getUrl()->getValue(),
                $news->getTitle()->getValue()
            ),
            $news->all()
        );

        $reportView = $this->reportConverter->convert(...$reportLines);

        return $this->reportExporter->export($reportView, $this->reportConverter->getFormat());
    }
}
