<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\UseCase\GenerateReport;

use PavelMiasnov\MediaMonitoring\Domain\Repository\NewsRepositoryInterface;
use PavelMiasnov\MediaMonitoring\Infrastructure\Service\ReportGenerator;

class GenerateReportUseCase
{
    private NewsRepositoryInterface $newsRepository;
    private ReportGenerator $reportGenerator;

    public function __construct(
        NewsRepositoryInterface $newsRepository,
        ReportGenerator $reportGenerator
    ) {
        $this->newsRepository = $newsRepository;
        $this->reportGenerator = $reportGenerator;
    }

    public function execute(GenerateReportRequest $request): GenerateReportResponse
    {
        $ids = $request->getIds();
        $newsList = $this->newsRepository->findByIds($ids);

        $reportPath = $this->reportGenerator->generate($newsList);

        return new GenerateReportResponse($reportPath);
    }
}
