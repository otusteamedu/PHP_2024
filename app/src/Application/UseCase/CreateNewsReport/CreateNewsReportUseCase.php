<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNewsReport;

use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\ReportRepositoryInterface;
use App\Domain\Report\ReportGeneratorInterface;

class CreateNewsReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $reportGenerator,
        private readonly ReportRepositoryInterface $reportRepository
    ) {
    }

    public function __invoke(CreateNewsReportRequest $request): CreateNewsReportResponse
    {
        $newsList = $this->newsRepository->findByIds($request->ids);
        $report = $this->reportGenerator->generateHTML($newsList);
        $reportFile = $this->reportRepository->save($report);

        return new CreateNewsReportResponse($reportFile->getPath());
    }
}
