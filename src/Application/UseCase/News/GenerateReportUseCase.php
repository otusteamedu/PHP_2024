<?php

declare(strict_types=1);

namespace App\Application\UseCase\News;

use App\Application\UseCase\News\Converter\ReportConverterInterface;
use App\Application\Gateway\ReportExporterInterface;
use App\Domain\Entity\News\{News, NewsRepositoryInterface};
use App\Domain\ValueObject\ReportLine;

class GenerateReportUseCase
{
    public function __construct(
        private ReportConverterInterface $reportConverter,
        private ReportExporterInterface $reportExporter,
        private NewsRepositoryInterface $newsRepository
    ) {
    }

    public function __invoke(int ...$ids): mixed
    {
        $news = $this->newsRepository->findByIds($ids);

        $reportLines = array_map(
            static fn (News $news) => new ReportLine($news->getUrl(), $news->getTitle()),
            $news->all()
        );

        $reportView = $this->reportConverter->convert(...$reportLines);

        return $this->reportExporter->export($reportView, $this->reportConverter->getFormat());
    }
}
