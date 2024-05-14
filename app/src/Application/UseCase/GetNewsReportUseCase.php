<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Service\LinkGeneratorInterface;
use App\Application\Service\NewsReportServiceInterface;
use App\Application\UseCase\Request\GetNewsReportRequest;
use App\Application\UseCase\Response\GetNewsReportResponse;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Service\NewsReportGeneratorInterface;

class GetNewsReportUseCase
{
    public function __construct(
        private readonly NewsReportGeneratorInterface $reportGenerator,
        private readonly NewsReportServiceInterface $reportService,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly LinkGeneratorInterface $linkGenerator
    ) {
    }

    public function __invoke(GetNewsReportRequest $request): GetNewsReportResponse
    {
        $news = $this->newsRepository->findAllByIds($request->ids);
        $reportDto = $this->reportGenerator->generate($news);
        $filename = $this->reportService->save($reportDto);
        $link = $this->linkGenerator->generate($filename);

        return new GetNewsReportResponse($link);
    }
}
