<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Service\DTO\ReportGeneratorInputDto;
use App\Application\Service\ReportGeneratorInterface;
use App\Application\UseCase\Response\CreateReportResponse;
use App\Application\UseCase\Response\DTO\ReportDto;
use App\Domain\Repository\NewsRepositoryInterface;

class CreateReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $newsReportGenerator,
    ) {
    }

    public function __invoke(): CreateReportResponse
    {
        $newsList = $this->newsRepository->findAll();
        $fileLink = $this->newsReportGenerator->generateReport(new ReportGeneratorInputDto($newsList));

        return new CreateReportResponse(new ReportDto($fileLink->reportUrl->getValue()));
    }
}
