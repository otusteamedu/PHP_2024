<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\CreateReportResponse;
use App\Application\UseCase\Response\DTO\ReportDto;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Service\ReportGeneratorInterface;

class CreateReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $newsReportGenerator,
    ) {
    }

    public function __invoke(): CreateReportResponse
    {
        $newsList = $this->newsRepository->getNewsList();
        $fileLink = $this->newsReportGenerator->generateReport($newsList);

        return new CreateReportResponse(new ReportDto($fileLink));
    }
}
