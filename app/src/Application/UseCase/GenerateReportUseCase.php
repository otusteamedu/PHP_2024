<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Report\Dto\SubmitReportGeneratorRequestDto;
use App\Application\Report\ReportGeneratorInterface;
use App\Application\UseCase\Dto\SubmitNewsItemsByIdsRequestDto;
use App\Application\UseCase\Dto\SubmitReportResponseDto;
use App\Domain\Repository\NewsItemRepositoryInterface;

class GenerateReportUseCase
{
    public function __construct(
        private readonly NewsItemRepositoryInterface $newsItemRepository,
        private readonly ReportGeneratorInterface $reportGenerator,
    ) {
    }

    public function __invoke(SubmitNewsItemsByIdsRequestDto $byIdsRequestDto): SubmitReportResponseDto
    {
        $newsItems = $this->newsItemRepository->findBy(['id' => $byIdsRequestDto->ids]);

        $reportGeneratorRequestDto = new SubmitReportGeneratorRequestDto($newsItems);
        $reportGeneratorResponseDto = $this->reportGenerator->generate($reportGeneratorRequestDto);

        return new SubmitReportResponseDto($reportGeneratorResponseDto->fileSrc);
    }
}
