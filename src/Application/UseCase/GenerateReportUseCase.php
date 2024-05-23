<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Helper\ReportGeneratorInterface;
use App\Application\UseCase\Form\GenerateReportForm;
use App\Application\UseCase\Response\GenerateReportResponse;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\Query\NewsByIdsQuery;

readonly class GenerateReportUseCase
{
    public function __construct(
        private NewsRepositoryInterface  $newsRepository,
        private ReportGeneratorInterface $reportGenerator,
    )
    {
    }

    public function __invoke(GenerateReportForm $form): GenerateReportResponse
    {
        $newsList = $this->newsRepository->findByIds(new NewsByIdsQuery($form->ids));

        $report = $this->reportGenerator->generate($newsList);
        return new GenerateReportResponse($report);
    }
}
