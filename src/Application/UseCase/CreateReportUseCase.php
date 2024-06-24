<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Service\Factory\ReportGeneratorFactoryInterface;
use App\Application\Service\ReportGeneratorInterface;
use App\Application\UseCase\Response\CreateReportResponse;
use App\Application\UseCase\Response\DTO\ReportDto;
use App\Domain\Repository\NewsRepositoryInterface;

class CreateReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $newsReportGenerator,
        private readonly ReportGeneratorFactoryInterface $factory,
    ) {
    }

    public function __invoke(): CreateReportResponse
    {
        $newsList = $this->newsRepository->findAll();
        $dtoList = $this->factory->createFromNews($newsList);
        $fileLink = $this->newsReportGenerator->generateReport($dtoList);

        return new CreateReportResponse($fileLink->reportUrl->getValue());
    }
}
