<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\GetNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\NewsReportServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\Report\ReportFileNotFoundException;

class GetNewsReportUseCase
{
    public function __construct(private NewsReportServiceInterface $newsReportService)
    {
    }

    /**
     * @throws ReportFileNotFoundException
     */
    public function __invoke(GetNewsReportRequest $request): string
    {
        return $this->newsReportService->getReportFullFilename($request->getFilename());
    }
}
