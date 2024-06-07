<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Helper\Mapper\NewsMapper;
use App\Application\Helper\ReportGeneratorInterface;
use App\Application\UseCase\Request\GenerateReportRequest;
use App\Application\UseCase\Response\GenerateReportResponse;
use App\Application\Validator\GenerateReportValidatorInterface;
use App\Domain\Repository\NewsRepositoryInterface;

readonly class GenerateReportUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
        private ReportGeneratorInterface $reportGenerator,
        private GenerateReportValidatorInterface $generateReportValidator
    ) {
    }

    public function __invoke(GenerateReportRequest $generateReportRequest): GenerateReportResponse
    {
        $this->generateReportValidator->validate($generateReportRequest);

        $newsList = $this->newsRepository->findByIds($generateReportRequest->ids);

        $report = $this->reportGenerator->generate(
            array_map(static fn($news) => NewsMapper::toNewsReportDTO($news), $newsList)
        );
        return new GenerateReportResponse($report->reportUrl);
    }
}
